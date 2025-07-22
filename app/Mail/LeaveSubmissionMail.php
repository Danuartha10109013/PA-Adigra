<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $sender;

    public function __construct($submission, $sender = null)
    {
        $this->submission = $submission;
        $this->sender = $sender;
    }

    public function build()
    {
        return $this->subject('Pengajuan Cuti')
            ->view('mail.leave_submission');
    }
} 