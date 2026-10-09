<?php

namespace App\Mail;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqAcknowledgementMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rfq $rfq)
    {
    }

    public function build(): self
    {
        return $this
            ->replyTo(config('website.procurement_email'), config('website.name').' Procurement')
            ->subject('RFQ received · '.$this->rfq->reference.' · Fida Technologies')
            ->view('emails.rfq-acknowledgement')
            ->with(['rfq' => $this->rfq]);
    }
}
