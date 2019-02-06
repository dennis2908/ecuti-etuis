<?php

namespace App\Mail\Ectr4u;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\OtherModel\Notification;

class Incompleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $filing;
    public $template;
    public $list;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filing, $subject)
    {
        $notification = Notification::where('code', 'ectr4u.incompleted')->first();

        $this->filing = $filing;
        $this->template = $notification->message;

        $data = htmlspecialchars($filing->logs()->where('activity_type_id', 20)->get()->last()->data);
        $data = array_filter(preg_split('~\R~u', $data));

        $this->list = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ectr4u.incompleted')->subject( "#".strtoupper(substr(uniqid(), 6, 6)).' - '.$this->subject )->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    }
}

