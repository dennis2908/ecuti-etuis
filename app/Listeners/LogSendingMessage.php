<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class LogSendingMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        \Storage::put('log.json', json_encode([
            "replyTo" => $message->getReplyTo(),
            "to" => $message->getTo(),
            "message" => $message
        ]));

        if(is_array($message->getReplyTo()))
            foreach($message->getReplyTo() as $sender_email => $sender_name) {
                //
            }
        else return;

        if(is_array($message->getTo()))
            foreach($message->getTo() as $receipient_email => $receipient_name) {
                //
            }
        else return;

        \Storage::put('log.json', json_encode([
            'replyTo' => $sender_email,
            'to' => $receipient_email,
            'subject' => $message->getSubject(),
            'message' => $message->getBody(),
        ]));

        $sender = User::where('email', $sender_email)->first();
        $receipient = User::where('email', $receipient_email)->first();

        if(!$sender || !$receipient)
            return;

        $receipient->inboxes()->firstOrCreate(
            [
                'subject' => $message->getSubject(),
            ],[
                'message' => $message->getBody(),
                'sender_user_id' => $sender->id,
                'inbox_status_id' => 2,
            ]
        );
    }
}
