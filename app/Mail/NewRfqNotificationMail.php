<?php

namespace App\Mail;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NewRfqNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rfq $rfq) {}

    public function build(): self
    {
        $mail = $this->subject('[RFQ] '.$this->rfq->reference.' · '.$this->rfq->organization_name)
            ->view('emails.new-rfq')
            ->with([
                'rfq' => $this->rfq,
                'adminUrl' => route('admin.rfqs.show', $this->rfq),
            ]);

        if (
            $this->rfq->attachment_path
            && $this->rfq->attachment_size
            && $this->rfq->attachment_size <= 8 * 1024 * 1024
            && Storage::disk('local')->exists($this->rfq->attachment_path)
        ) {
            $mail->attachFromStorageDisk(
                'local',
                $this->rfq->attachment_path,
                $this->rfq->attachment_name ?: basename($this->rfq->attachment_path),
                array_filter(['mime' => $this->rfq->attachment_mime]),
            );
        }

        return $mail;
    }
}
