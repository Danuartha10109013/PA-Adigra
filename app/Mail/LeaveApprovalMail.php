<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $approver;

    public function __construct($submission, $approver = null)
    {
        $this->submission = $submission;
        $this->approver = $approver;
    }

    public function build()
    {
        return $this->subject('Pengajuan Cuti Disetujui')
            ->view('mail.leave_approval');
    }
} 