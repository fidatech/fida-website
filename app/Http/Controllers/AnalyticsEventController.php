<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Models\WebsiteAnalyticsEvent;
use App\Support\TrafficClassifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsEventController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'event_name' => ['required', 'string', 'max:80'],
            'event_label' => ['nullable', 'string', 'max:255'],
            'path' => ['nullable', 'string', 'max:512'],
        ]);

        if (! in_array($data['event_name'], ['cta_click', 'contact_open', 'phone_click', 'email_click', 'whatsapp_click'], true)) {
            abort(422);
        }

        $keys = TrafficClassifier::keys($request);
        $now = now();
        $routePage = $request->route('page');

        WebsiteAnalyticsEvent::create([
            'occurred_at' => $now,
            'day' => $now->toDateString(),
            'visitor_key' => $keys['visitor_key'],
            'session_key' => $keys['session_key'],
            'event_name' => $data['event_name'],
            'event_label' => $data['event_label'] ?? null,
            'path' => $data['path'] ?? '/'.ltrim($request->path(), '/'),
            'page_slug' => $routePage instanceof ContentPage ? $routePage->slug : null,
            'locale' => app()->getLocale(),
            'metadata' => ['referrer' => $request->headers->get('referer')],
        ]);

        return response()->json(['ok' => true]);
    }
}
