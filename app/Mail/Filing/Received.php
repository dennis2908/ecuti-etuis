<?php

namespace App\Mail\Filing;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;

class Received extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $filing;
    public $template;
    public $subject;
    public $sender;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $filing, $subject)
    {
        $notification = Notification::where('code', 'filing.received')->first();

        $this->filing = $filing;
        $this->template = $notification->message;
        $this->subject = $subject;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.filing.received')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo($this->sender->email, $this->sender->name);
    }
}
