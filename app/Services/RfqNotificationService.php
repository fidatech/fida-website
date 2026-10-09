<?php

namespace App\Services;

use App\Mail\NewRfqNotificationMail;
use App\Mail\RfqAcknowledgementMail;
use App\Models\Rfq;
use Illuminate\Support\Facades\Mail;

class RfqNotificationService
{
    public function send(Rfq $rfq): void
    {
        try {
            Mail::to(config('website.rfq_email', 'info@fida.af'))->send(new NewRfqNotificationMail($rfq));
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            Mail::to($rfq->email)->send(new RfqAcknowledgementMail($rfq));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
