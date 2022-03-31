<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $service;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry, $service = null)
    {
        $this->inquiry = $inquiry;
        $this->service = $service;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->service ? $this->service->title : $this->inquiry->contact_subject;

        return $this->from('purplebug.website@purplebug.net')
            ->subject("PurpleBug Inquiry - {$subject}")
            ->markdown('emails.inquire');
    }
}
