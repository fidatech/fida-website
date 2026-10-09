<?php

namespace App\Mail;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRfqNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rfq $rfq) {}

    public function build(): self
    {
        return $this->subject('[RFQ] '.$this->rfq->reference.' · '.$this->rfq->organization_name)
            ->view('emails.new-rfq')
            ->with([
                'rfq' => $this->rfq,
                'adminUrl' => route('admin.rfqs.show', $this->rfq),
            ]);
    }
}
