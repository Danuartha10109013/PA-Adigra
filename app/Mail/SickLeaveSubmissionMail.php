<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SickLeaveSubmissionMail extends Mailable
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
        return $this->subject('Pengajuan Izin/Sakit')
            ->view('mail.sick_leave_submission');
    }
} 