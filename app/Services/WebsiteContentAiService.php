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

        $provider = in_array(($value['provider'] ?? null), ['gemini', 'openrouter', 'openai'], true)
            ? $value['provider']
            : 'gemini';
        $savedModel = trim((string) ($value['model'] ?? ''));

        return [
            'provider' => $provider,
            'model' => $savedModel !== '' ? $savedModel : $this->defaultModel($provider),
            'api_key' => $this->decryptKey($value['api_key'] ?? null),
        ];
    }

    private function generateJson(string $prompt, int $maxTokens): array
    {
        $config = $this->configuration();

        if (! filled($config['api_key'])) {
            throw new RuntimeException('Add an AI API key in Brand & settings first.');
        }

        $raw = match ($config['provider']) {
            'openrouter' => $this->openRouter($config, $prompt, $maxTokens),
            'openai' => $this->openAi($config, $prompt, $maxTokens),
            default => $this->gemini($config, $prompt, $maxTokens),
        };

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

    private function openAi(array $config, string $prompt, int $maxTokens): string
    {
        $response = Http::withToken($config['api_key'])
            ->acceptJson()
            ->asJson()
            ->timeout(75)
            ->retry(2, 900)
            ->post('https://api.openai.com/v1/responses', [
                'model' => $config['model'],
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [[
                            'type' => 'input_text',
                            'text' => 'Return only valid JSON. Never invent clients, facts, numbers, certifications, laws, prices, dates, quotations, product capabilities or outcomes. Do not reveal chain-of-thought.',
                        ]],
                    ],
                    [
                        'role' => 'user',
                        'content' => [[
                            'type' => 'input_text',
                            'text' => $prompt,
                        ]],
                    ],
                ],
                'reasoning' => ['effort' => 'none'],
                'max_output_tokens' => $maxTokens,
                'text' => ['format' => ['type' => 'json_object']],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('OpenAI request failed: '.$response->status().' '.$response->json('error.message', 'Unknown API error'));
        }

        $text = $response->json('output.0.content.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new RuntimeException('OpenAI returned empty content.');
        }

        return $text;
    }

    private function defaultModel(string $provider): string
    {
        return match ($provider) {
            'openai' => 'gpt-5.6-luna',
            'openrouter' => 'openrouter/free',
            default => 'gemini-3.8-flash',
        };
    }

    private function articlePrompt(array $context): string
    {
        return <<<'PROMPT'
You are the multilingual editorial engine for Fida Technologies, an Afghanistan-based enterprise software company.

Create ONE useful, original article that can earn search visibility and help a real buyer. Never create a thin doorway page.

Hard rules:
- Use only the evidence/context supplied below. If the context does not support a factual or current claim, omit it or list it under facts_to_verify.
- Do not invent customer names, market-share claims, laws, regulations, statistics, prices, awards, certifications, dates, quotations, product capabilities or outcomes.
- Do not create a page just to target a keyword variation, city variation, industry-name variation or near-duplicate search phrase.
- Avoid a topic or primary search intent already covered by EXISTING CONTENT.
- Prefer a real buyer question or decision from SEARCH OPPORTUNITIES or the editorial themes.
- Add practical value: decision criteria, workflow guidance, trade-offs, implementation steps, risks, checklists or examples that are clearly generic.
- The article must be useful even if the reader never buys from Fida. Keep promotional copy secondary to the answer.
- Never claim first-hand experience, a client implementation, local market fact or government requirement unless that evidence is explicitly present in CONTEXT.
- Do not stuff keywords or repeat "Afghanistan", "ERP", "system", "database" or similar terms unnaturally.
- English, Dari and Pashto must be natural localized versions, not word-for-word translations. Do not leave English filler inside Dari/Pashto when a clear local term is available.
- In Dari/Pashto, naturally use Afghan terminology where relevant: دیتابیس / ډیټابیس, گدام / ګدام, سیستم, سافټویر.
- Give each language clear substantive sections with at least two h2 headings and at least one practical list where appropriate.
- HTML allowed only: h2,h3,p,ul,ol,li,strong,em,a. Do not output scripts, styles, iframes, images or markdown.
- Keep title under 70 characters when practical and meta description under 160 characters.
- Return only JSON.

Required JSON:
{
  "slug":"lowercase-kebab-case",
  "title":{"en":"","fa":"","ps":""},
  "eyebrow":{"en":"Fida Answers","fa":"پاسخ‌های فدا","ps":"د فدا ځوابونه"},
  "summary":{"en":"","fa":"","ps":""},
  "body":{"en":"<h2>...</h2>...","fa":"...","ps":"..."},
  "meta_title":{"en":"","fa":"","ps":""},
  "meta_description":{"en":"","fa":"","ps":""},
  "primary_query":{"en":"","fa":"","ps":""},
  "related_slugs":["existing-slug","existing-slug"],
  "editor_note":"one short sentence explaining why this topic was selected",
  "quality":{
    "publishable":true,
    "distinctive_value":"what this article gives the reader that existing pages do not",
    "facts_to_verify":["any statement a human editor should verify before publishing"],
    "sources_needed":["source or internal evidence needed for any unresolved claim"]
  }
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
