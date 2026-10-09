<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRfqRequest;
use App\Mail\NewRfqNotificationMail;
use App\Mail\RfqAcknowledgementMail;
use App\Models\ContentPage;
use App\Models\Rfq;
use App\Models\WebsiteAnalyticsEvent;
use App\Support\LocalizedUrl;
use App\Support\SeoSchema;
use App\Support\TrafficClassifier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class RfqController extends Controller
{
    public function create(): View
    {
        $page = ContentPage::published()->where('slug', 'request-for-quotation')->firstOrFail();
        $seo = [
            'title' => $page->translation('meta_title') ?: $page->translation('title').' | '.config('website.name'),
            'description' => $page->translation('meta_description') ?: $page->translation('summary'),
            'canonical' => LocalizedUrl::path('/request-for-quotation'),
            'robots' => $page->robotsDirective(),
            'image' => $page->socialImage(),
        ];
        $faqs = $page->faqs();

        return view('marketing.rfq', [
            'page' => $page,
            'seo' => $seo,
            'faqs' => $faqs,
            'capabilities' => config('website.featured_solutions'),
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs),
        ]);
    }

    public function store(StoreRfqRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (filled($data['website'] ?? null)) {
            return back()->with('rfq_success', 'Thank you. Your request has been received.');
        }

        unset($data['website'], $data['document'], $data['privacy_accepted']);
        $rfq = new Rfq($data);
        $rfq->reference = 'RFQ-'.now()->format('Ymd').'-'.strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $rfq->attachment_path = $file->store('rfq-documents', 'local');
            $rfq->attachment_name = $file->getClientOriginalName();
            $rfq->attachment_mime = $file->getMimeType();
            $rfq->attachment_size = $file->getSize();
        }

        $rfq->save();

        try {
            Mail::to(config('website.procurement_email'))->send(new NewRfqNotificationMail($rfq));
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            Mail::to($rfq->email)->send(new RfqAcknowledgementMail($rfq));
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $keys = TrafficClassifier::keys($request);
            $now = now();

            WebsiteAnalyticsEvent::create([
                'occurred_at' => $now,
                'day' => $now->toDateString(),
                'visitor_key' => $keys['visitor_key'],
                'session_key' => $keys['session_key'],
                'event_name' => 'rfq_submitted',
                'event_label' => $rfq->organization_type,
                'path' => parse_url((string) $rfq->source_url, PHP_URL_PATH) ?: '/request-for-quotation',
                'page_slug' => 'request-for-quotation',
                'locale' => $rfq->locale,
                'metadata' => [
                    'reference' => $rfq->reference,
                    'procurement_method' => $rfq->procurement_method,
                ],
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        $locale = (string) ($data['locale'] ?? config('website.default_locale'));
        $path = $locale === config('website.default_locale')
            ? '/request-for-quotation'
            : '/'.$locale.'/request-for-quotation';

        return redirect()->to(url($path).'#rfq-form')
            ->with('rfq_success', 'Your RFQ has been received. Reference: '.$rfq->reference);
    }
}
