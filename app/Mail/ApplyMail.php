<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $career;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $career = null, $fileName)
    {
        $this->applicant = $applicant;
        $this->career = $career;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->career ? $this->career->title : $this->applicant->name;

        return $this->from('purplebug.website@purplebug.net')
            ->subject("PurpleBug Careers - {$subject}")
            ->markdown('emails.apply')
            ->attachFromStorage("/applicants/{$this->fileName}");
    }
}
