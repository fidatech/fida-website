<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRfqRequest;
use App\Models\Rfq;
use App\Models\WebsiteAnalyticsEvent;
use App\Services\RfqNotificationService;
use App\Support\TrafficClassifier;
use Illuminate\Http\RedirectResponse;

class RfqController extends Controller
{
    public function store(StoreRfqRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['documents', 'website']);
        $data['locale'] = $data['locale'] ?? app()->getLocale();
        $data['status'] = 'new';

        $rfq = Rfq::query()->create($data);
        $rfq->update([
            'reference' => 'RFQ-'.now()->format('Y').'-'.str_pad((string) $rfq->id, 6, '0', STR_PAD_LEFT),
        ]);

        $attachments = [];

        foreach ($request->file('documents', []) as $document) {
            $path = $document->store('rfqs/'.$rfq->id, 'local');

            if (! is_string($path)) {
                continue;
            }

            $attachments[] = [
                'name' => mb_substr($document->getClientOriginalName(), 0, 255),
                'path' => $path,
                'mime' => (string) $document->getMimeType(),
                'size' => (int) $document->getSize(),
            ];
        }

        if ($attachments !== []) {
            $rfq->update(['attachments' => $attachments]);
        }

        app(RfqNotificationService::class)->send($rfq->fresh());

        try {
            $keys = TrafficClassifier::keys($request);
            $now = now();

            WebsiteAnalyticsEvent::query()->create([
                'occurred_at' => $now,
                'day' => $now->toDateString(),
                'visitor_key' => $keys['visitor_key'],
                'session_key' => $keys['session_key'],
                'event_name' => 'rfq_submitted',
                'event_label' => $rfq->procurement_type,
                'path' => mb_substr((string) ($rfq->source_url ?: '/request-for-quotation'), 0, 512),
                'page_slug' => 'request-for-quotation',
                'locale' => $rfq->locale,
                'metadata' => [
                    'reference' => $rfq->reference,
                    'organization_type' => $rfq->organization_type,
                ],
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return back()->with('rfq_success', $rfq->reference);
    }
}
