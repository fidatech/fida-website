<?php

namespace App\Services;

use App\Mail\NewLeadNotificationMail;
use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;

class LeadNotificationService
{
    public function send(Lead $lead): void
    {
        $settings = $this->settings();

        if (! $settings['email_enabled'] || $settings['email_recipient'] === '') {
            return;
        }

        try {
            Mail::to($settings['email_recipient'])->send(new NewLeadNotificationMail($lead));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    public function settings(): array
    {
        $setting = SiteSetting::query()->where('key', 'leads.notifications')->first();
        $value = is_array($setting?->value) ? $setting->value : [];

        return [
            'email_enabled' => array_key_exists('email_enabled', $value)
                ? (bool) $value['email_enabled']
                : true,
            'email_recipient' => trim((string) ($value['email_recipient'] ?? config('website.email'))),
        ];
    }
}
