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
        $content = $config['provider'] === 'openrouter'
            ? $this->openRouter($config, $prompt)
            : $this->gemini($config, $prompt);

        return [
            'provider' => $config['provider'],
            'model' => $config['model'],
            'content' => trim($content),
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
                        'temperature' => 0.25,
                        'maxOutputTokens' => 1800,
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
                    ['role' => 'system', 'content' => 'You are a practical growth analyst for an enterprise software company. Base recommendations only on the supplied analytics.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.25,
                'max_tokens' => 1800,
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
Analyze the following website analytics for Fida Technologies, an enterprise software company.

Your job is to recommend what the company should build, publish, or sell next. Focus on:
- ERP/product opportunities suggested by visitor behavior and search demand.
- Commercial topics/pages that could attract qualified clients.
- Which existing pages should be improved first.
- Which countries/markets deserve attention only when the data supports it.
- Conversion improvements.
- Distinguish real visitor data from Google Search Console data.

Return concise plain text with these exact headings:
EXECUTIVE FOCUS
ERP / PRODUCT OPPORTUNITIES
CONTENT OPPORTUNITIES
CONVERSION ACTIONS
WHAT NOT TO PRIORITIZE YET

Under each heading use short bullet points. For each recommendation explain the data signal behind it. Do not invent demand or market facts that are not present in the supplied data.

DATA:
PROMPT
            ."
".json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
