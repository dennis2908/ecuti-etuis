<?php

namespace App\Mail\FormJ;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;

class ApprovedPWN extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $filing;
    public $template;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filing, $subject)
    {
        $notification = Notification::where('code', 'formj.approved-pwn')->first();

        $this->filing = $filing;
        $this->template = $notification->message;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.formj.approved-pwn')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    }
}