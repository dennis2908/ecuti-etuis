<?php

namespace App\Mail\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;
use App\User;

class AppealRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $template;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $notification = Notification::where('code', 'PB_KS_1.4')->first();

        $this->user = $user;
        $this->template = $notification->message;
        $this->subject = $notification->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.registration.appeal_rejected')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    }
}
