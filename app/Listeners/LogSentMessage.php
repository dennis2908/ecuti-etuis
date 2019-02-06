<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
// use App\User;

class LogSentMessage
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
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        // $message = $event->message;

        // if(is_array($message->getReplyTo()))
        //     foreach($message->getReplyTo() as $sender_email => $sender_name) {
        //         //
        //     }
        // else return;

        // if(is_array($message->getTo()))
        //     foreach($message->getTo() as $receipient_email => $receipient_name) {
        //         //
        //     }
        // else return;

        // \Storage::put('log.json', json_encode([
        //     'replyTo' => $sender_email,
        //     'to' => $receipient_email,
        //     'subject' => $message->getSubject(),
        //     'message' => $message->getBody(),
        // ]));

        // $sender = User::where('email', $sender_email)->first();
        // $receipient = User::where('email', $receipient_email)->first();

        // if(!$sender || !$receipient)
        //     return;

        // $receipient->inboxes()->create([
        //     'sender_user_id' => $sender->id,
        //     'subject' => $message->getSubject(),
        //     'message' => $message->getBody(),
        //     'inbox_status_id' => 2,
        // ]);
    }
}
