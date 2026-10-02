<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AnalyticsAiAdvisor
{
    public function configuration(): array
    {
        $setting = SiteSetting::query()->where('key', 'analytics.ai')->first();
        $value = is_array($setting?->value) ? $setting->value : [];

        return [
            'provider' => in_array(($value['provider'] ?? null), ['gemini', 'openrouter'], true) ? $value['provider'] : 'gemini',
            'model' => trim((string) ($value['model'] ?? 'gemini-3.8-flash')),
            'api_key' => $this->decryptKey($value['api_key'] ?? null),
        ];
    }

    public function configured(): bool
    {
        return filled($this->configuration()['api_key']);
    }

    public function generate(array $summary): array
    {
        $config = $this->configuration();

        if (! filled($config['api_key'])) {
            throw new RuntimeException('Add an AI API key in Brand & settings first.');
        }

        $prompt = $this->prompt($summary);
        $raw = $config['provider'] === 'openrouter'
            ? $this->openRouter($config, $prompt)
            : $this->gemini($config, $prompt);

        $decision = $this->extractDecision($raw);

        return [
            'provider' => $config['provider'],
            'model' => $config['model'],
            'content' => json_encode($decision, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            'decision' => $decision,
        ];
    }

    private function gemini(array $config, string $prompt): string
    {
        $response = Http::asJson()
            ->timeout(45)
            ->retry(2, 700)
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/'.rawurlencode($config['model']).':generateContent?key='.urlencode($config['api_key']),
                [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                    'generationConfig' => [
                        'temperature' => 0.15,
                        'maxOutputTokens' => 2200,
                        'responseMimeType' => 'application/json',
                    ],
                ],
            );

        if (! $response->successful()) {
            throw new RuntimeException('Gemini request failed: '.$response->status().' '.$response->json('error.message', 'Unknown API error'));
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new RuntimeException('Gemini returned an empty recommendation.');
        }

        return $text;
    }

    private function openRouter(array $config, string $prompt): string
    {
        $response = Http::withToken($config['api_key'])
            ->acceptJson()
            ->asJson()
            ->timeout(45)
            ->retry(2, 700)
            ->withHeaders([
                'HTTP-Referer' => url('/'),
                'X-Title' => config('website.name').' Analytics Advisor',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $config['model'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Return only the requested JSON object. Do not reveal chain-of-thought, hidden reasoning, analysis steps, scratch work, or a thinking process. Base every recommendation on supplied evidence.',
                    ],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.15,
                'max_tokens' => 2200,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('OpenRouter request failed: '.$response->status().' '.$response->json('error.message', 'Unknown API error'));
        }

        $text = $response->json('choices.0.message.content');

        if (! is_string($text) || trim($text) === '') {
            throw new RuntimeException('OpenRouter returned an empty recommendation.');
        }

        return $text;
    }

    private function prompt(array $summary): string
    {
        return <<<'PROMPT'
You are the decision-support analyst for Fida Technologies, an enterprise software company.

This dashboard is for the company owner. He does NOT need a summary of data he can already see. He needs a small number of concrete decisions.

Rules:
1. Do not repeat the analytics table.
2. Do not output a thinking process, chain-of-thought, hidden reasoning, planning steps, or meta commentary.
3. Recommend at most 5 priorities total.
4. A priority must tell the owner exactly what to DO, not merely what the data says.
5. Do not recommend creating a page/product that already exists in EXISTING WEBSITE INVENTORY. If demand exists for an existing page, recommend improving, expanding, localizing, promoting or converting that page instead.
6. Treat tiny samples carefully. Low-volume signals must have medium or low confidence.
7. Distinguish REAL VISITOR data from GOOGLE SEARCH CONSOLE data.
8. Search impressions are not customer demand by themselves. Do not recommend entering a country or building a product solely because of impressions.
9. Prefer commercial actions: improve a high-opportunity landing page, package an ERP offer, create a comparison/pricing/implementation page, publish a high-intent article, improve CTA/WhatsApp conversion, or test a focused campaign.
10. If the available evidence is too weak for a new ERP/product, say so and recommend a measurement/content test instead.
11. Evidence must use exact numbers from the supplied data.
12. Keep each string concise. No markdown.

Return ONLY valid JSON in this exact shape:
{
  "headline": "one-line business direction",
  "summary": "2-3 sentences maximum",
  "priorities": [
    {
      "type": "ERP / Product | Content / SEO | Conversion | Measurement",
      "title": "short action title",
      "decision": "one sentence telling the owner what to do",
      "business_reason": "why this can matter commercially",
      "evidence": ["exact metric", "exact metric"],
      "next_steps": ["specific step 1", "specific step 2", "specific step 3"],
      "confidence": "high | medium | low"
    }
  ],
  "watchlist": [
    {
      "signal": "thing worth watching",
      "trigger": "what future evidence would justify action"
    }
  ],
  "do_not_prioritize": [
    "short item with evidence-based reason"
  ],
  "data_quality_notes": [
    "important limitation that affects interpretation"
  ]
}

DATA:
PROMPT
            ."\n".json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function extractDecision(string $raw): array
    {
        $candidate = trim($raw);
        $first = strpos($candidate, '{');
        $last = strrpos($candidate, '}');

        if ($first !== false && $last !== false && $last > $first) {
            $candidate = substr($candidate, $first, $last - $first + 1);
        }

        $decoded = json_decode($candidate, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('The AI provider did not return a usable business recommendation. Generate again or choose a different model.');
        }

        $priorities = collect($decoded['priorities'] ?? [])
            ->filter(fn ($item) => is_array($item))
            ->take(5)
            ->map(function (array $item): array {
                $confidence = strtolower(trim((string) ($item['confidence'] ?? 'low')));

                return [
                    'type' => $this->clean($item['type'] ?? 'Measurement', 40),
                    'title' => $this->clean($item['title'] ?? 'Next action', 120),
                    'decision' => $this->clean($item['decision'] ?? '', 320),
                    'business_reason' => $this->clean($item['business_reason'] ?? '', 320),
                    'evidence' => $this->cleanList($item['evidence'] ?? [], 3, 180),
                    'next_steps' => $this->cleanList($item['next_steps'] ?? [], 4, 220),
                    'confidence' => in_array($confidence, ['high', 'medium', 'low'], true) ? $confidence : 'low',
                ];
            })
            ->filter(fn (array $item) => $item['decision'] !== '')
            ->values()
            ->all();

        if ($priorities === []) {
            throw new RuntimeException('The AI provider returned no actionable priorities. Generate again or choose a different model.');
        }

        return [
            'headline' => $this->clean($decoded['headline'] ?? 'Focus on the strongest measurable commercial signal.', 180),
            'summary' => $this->clean($decoded['summary'] ?? '', 600),
            'priorities' => $priorities,
            'watchlist' => collect($decoded['watchlist'] ?? [])
                ->filter(fn ($item) => is_array($item))
                ->take(4)
                ->map(fn (array $item) => [
                    'signal' => $this->clean($item['signal'] ?? '', 180),
                    'trigger' => $this->clean($item['trigger'] ?? '', 260),
                ])
                ->filter(fn (array $item) => $item['signal'] !== '')
                ->values()
                ->all(),
            'do_not_prioritize' => $this->cleanList($decoded['do_not_prioritize'] ?? [], 5, 260),
            'data_quality_notes' => $this->cleanList($decoded['data_quality_notes'] ?? [], 5, 260),
        ];
    }

    private function clean(mixed $value, int $limit): string
    {
        $text = trim(strip_tags((string) $value));
        $text = preg_replace('/\s+/', ' ', $text) ?? $text;

        return mb_substr($text, 0, $limit);
    }

    private function cleanList(mixed $items, int $maxItems, int $limit): array
    {
        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(fn ($item) => $this->clean($item, $limit))
            ->filter()
            ->take($maxItems)
            ->values()
            ->all();
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
