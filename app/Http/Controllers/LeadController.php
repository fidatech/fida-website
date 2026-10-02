<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Models\WebsiteAnalyticsEvent;
use App\Support\TrafficClassifier;
use App\Services\LeadNotificationService;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    public function __invoke(StoreLeadRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['locale'] = $data['locale'] ?? app()->getLocale();
        $data['status'] = 'new';

        app()->setLocale($data['locale']);

        $lead = Lead::create($data);

        app(LeadNotificationService::class)->send($lead);

        try {
            $keys = TrafficClassifier::keys($request);
            $now = now();

            WebsiteAnalyticsEvent::create([
                'occurred_at' => $now,
                'day' => $now->toDateString(),
                'visitor_key' => $keys['visitor_key'],
                'session_key' => $keys['session_key'],
                'event_name' => 'lead_submitted',
                'event_label' => $data['project_type'] ?? 'website_form',
                'path' => mb_substr((string) ($data['source_url'] ?? $request->headers->get('referer') ?? '/contact'), 0, 512),
                'page_slug' => $data['interest_slug'] ?? null,
                'locale' => $data['locale'],
                'metadata' => [
                    'utm_source' => $data['utm_source'] ?? null,
                    'utm_medium' => $data['utm_medium'] ?? null,
                    'utm_campaign' => $data['utm_campaign'] ?? null,
                ],
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return back()->with('lead_success', __('website.contact.success'));
    }
}
