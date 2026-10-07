<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WebsiteContentAiService
{
    public function configured(): bool
    {
        return filled($this->configuration()['api_key']);
    }

    public function generateArticle(array $context): array
    {
        return $this->generateJson($this->articlePrompt($context), 5200);
    }

    public function generateCaseStudy(array $answers): array
    {
        return $this->generateJson($this->caseStudyPrompt($answers), 5200);
    }

    private function configuration(): array
    {
        $setting = SiteSetting::query()->where('key', 'analytics.ai')->first();
        $value = is_array($setting?->value) ? $setting->value : [];

        return [
            'provider' => in_array(($value['provider'] ?? null), ['gemini', 'openrouter'], true) ? $value['provider'] : 'gemini',
            'model' => trim((string) ($value['model'] ?? 'gemini-3.8-flash')),
            'api_key' => $this->decryptKey($value['api_key'] ?? null),
        ];
    }

    private function generateJson(string $prompt, int $maxTokens): array
    {
        $config = $this->configuration();

        if (! filled($config['api_key'])) {
            throw new RuntimeException('Add an AI API key in Brand & settings first.');
        }

        $raw = $config['provider'] === 'openrouter'
            ? $this->openRouter($config, $prompt, $maxTokens)
            : $this->gemini($config, $prompt, $maxTokens);

        $candidate = trim($raw);
        $first = strpos($candidate, '{');
        $last = strrpos($candidate, '}');

        if ($first !== false && $last !== false && $last > $first) {
            $candidate = substr($candidate, $first, $last - $first + 1);
        }

        $decoded = json_decode($candidate, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('The AI provider did not return valid structured content.');
        }

        return $decoded;
    }

    private function gemini(array $config, string $prompt, int $maxTokens): string
    {
        $response = Http::asJson()->timeout(75)->retry(2, 900)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/'.rawurlencode($config['model']).':generateContent?key='.urlencode($config['api_key']),
            [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'temperature' => 0.35,
                    'maxOutputTokens' => $maxTokens,
                    'responseMimeType' => 'application/json',
                ],
            ],
        );

        if (! $response->successful()) {
            throw new RuntimeException('Gemini request failed: '.$response->status().' '.$response->json('error.message', 'Unknown API error'));
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new RuntimeException('Gemini returned empty content.');
        }

        return $text;
    }

    private function openRouter(array $config, string $prompt, int $maxTokens): string
    {
        $response = Http::withToken($config['api_key'])
            ->acceptJson()->asJson()->timeout(75)->retry(2, 900)
            ->withHeaders([
                'HTTP-Referer' => url('/'),
                'X-Title' => config('website.name').' Content Studio',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $config['model'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Return only valid JSON. Never invent clients, performance numbers, certifications, regulatory claims, dates, quotations, or outcomes not explicitly supplied. Do not reveal chain-of-thought.',
                    ],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.35,
                'max_tokens' => $maxTokens,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('OpenRouter request failed: '.$response->status().' '.$response->json('error.message', 'Unknown API error'));
        }

        $text = $response->json('choices.0.message.content');

        if (! is_string($text) || trim($text) === '') {
            throw new RuntimeException('OpenRouter returned empty content.');
        }

        return $text;
    }

    private function articlePrompt(array $context): string
    {
        return <<<'PROMPT'
You are the multilingual editorial engine for Fida Technologies, an Afghanistan-based enterprise software company.

Create ONE useful, original article that can earn search visibility and help a real buyer. Never create a thin doorway page.

Hard rules:
- Use only the evidence/context supplied below.
- Do not invent customer names, market-share claims, legal requirements, statistics, prices, awards or product capabilities.
- Avoid a topic or primary search intent that already exists in EXISTING CONTENT.
- Prefer a high-intent opportunity from SEARCH OPPORTUNITIES or the editorial themes supplied.
- The article must be useful even if the reader never buys from Fida.
- English, Dari and Pashto must be natural localized versions, not word-for-word translations.
- In Dari/Pashto, naturally use Afghan terminology where relevant: دیتابیس / ډیټابیس, گدام / ګدام, سیستم, سافټویر.
- HTML allowed only: h2,h3,p,ul,ol,li,strong,em,a. Do not output scripts, styles, iframes, images or markdown.
- Keep title under 70 characters when practical and meta description under 160 characters.
- Return only JSON.

Required JSON:
{
  "slug":"lowercase-kebab-case",
  "title":{"en":"","fa":"","ps":""},
  "eyebrow":{"en":"Fida Answers","fa":"پاسخ‌های فیدا","ps":"د فیدا ځوابونه"},
  "summary":{"en":"","fa":"","ps":""},
  "body":{"en":"<h2>...</h2>...","fa":"...","ps":"..."},
  "meta_title":{"en":"","fa":"","ps":""},
  "meta_description":{"en":"","fa":"","ps":""},
  "primary_query":{"en":"","fa":"","ps":""},
  "related_slugs":["existing-slug","existing-slug"],
  "editor_note":"one short sentence explaining why this topic was selected"
}

CONTEXT:
PROMPT
            ."
".json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    private function caseStudyPrompt(array $answers): string
    {
        return <<<'PROMPT'
You are the case-study editor for Fida Technologies.

Turn the supplied interview answers into a professional case-study DRAFT in English, Dari and Pashto.

Rules:
- Do not invent any fact, client name, module, metric, date, outcome or testimonial.
- If the client must stay private, describe it generically and do not infer identity.
- Separate the client's problem, Fida's verified scope, implementation approach, delivered capabilities, and verified outcomes.
- If no measurable outcome was supplied, use qualitative wording only.
- Do not claim publication permission. The admin evidence checklist controls that separately.
- HTML allowed only: h2,h3,p,ul,ol,li,strong,em,a.
- Return only JSON.

Required JSON:
{
  "slug":"lowercase-kebab-case",
  "title":{"en":"","fa":"","ps":""},
  "eyebrow":{"en":"Implementation case study","fa":"مطالعه موردی تطبیق","ps":"د پلي کولو قضیوي مطالعه"},
  "summary":{"en":"","fa":"","ps":""},
  "body":{"en":"","fa":"","ps":""},
  "meta_title":{"en":"","fa":"","ps":""},
  "meta_description":{"en":"","fa":"","ps":""},
  "primary_query":{"en":"","fa":"","ps":""},
  "editor_note":"short note about missing evidence or facts that should be confirmed"
}

INTERVIEW ANSWERS:
PROMPT
            ."
".json_encode($answers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    private function decryptKey(mixed $encrypted): ?string
    {
        if (! is_string($encrypted) || trim($encrypted) === '') {
            return null;
        }

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Throwable) {
            return null;
        }
    }
}
