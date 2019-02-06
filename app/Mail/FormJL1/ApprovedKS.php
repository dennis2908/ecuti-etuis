<?php

namespace App\Mail\FormJL1;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;

class ApprovedKS extends Mailable implements ShouldQueue
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
        $notification = Notification::where('code', 'formjl1.approved-ks')->first();

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
        return $this->markdown('emails.formjl1.approved-ks')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    }
}