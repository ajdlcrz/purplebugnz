<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfluencerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $influencer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($influencer)
    {
        $this->influencer = $influencer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('purplebug.website@purplebug.net')
            ->subject("New Influencer Registered")
            ->markdown('emails.influencer');
    }
}
