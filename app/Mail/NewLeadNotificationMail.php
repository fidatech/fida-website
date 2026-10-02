<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLeadNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('New website lead: '.$this->lead->name)
            ->view('emails.new-lead')
            ->with([
                'lead' => $this->lead,
                'adminUrl' => route('admin.leads.show', $this->lead),
            ]);
    }
}
