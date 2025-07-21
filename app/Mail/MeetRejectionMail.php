<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meet;
    public $sender;

    public function __construct($meet, $sender = null)
    {
        $this->meet = $meet;
        $this->sender = $sender;
    }

    public function build()
    {
        return $this->subject('Meeting Ditolak')
            ->view('mail.meet_rejection');
    }
} 