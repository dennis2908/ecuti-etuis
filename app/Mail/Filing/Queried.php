<?php

namespace App\Mail\Filing;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;

class Queried extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $queries;
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
        $notification = Notification::where('code', 'filing.queried')->first();

        $this->queries = $filing->queries()->whereNull('log_filing_id')->where('created_by_user_id', auth()->id())->get();
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
        return $this->markdown('emails.filing.queried')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo($this->sender->email, $this->sender->name);
    }
}
