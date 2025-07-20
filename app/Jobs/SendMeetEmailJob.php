<?php

namespace App\Jobs;

use App\Mail\MeetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendMeetEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $meet;
    protected $user;

    public function __construct($meet, User $user)
    {
        $this->meet = $meet;
        $this->user = $user;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new MeetMail($this->meet));
    }
}
