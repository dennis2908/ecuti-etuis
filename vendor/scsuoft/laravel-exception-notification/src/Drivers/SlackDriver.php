<?php

namespace LaravelExceptionNotification\Drivers;

use Carbon\Carbon;
use Razorpay\Slack\Attachment;
use Razorpay\Slack\AttachmentField;
use Slack;
use Illuminate\Support\Facades\Log;
class SlackDriver implements DriverInterface
{
    public function send(\Exception $exception)
    {
        try{
            $config     = config('exception-notification.slack');
            $message    = 'Exception has been thrown on `' . config('app.url') . '`';
            $attachment = new Attachment([
                'color'  => 'danger',
                'fields' => [
                    new AttachmentField([
                        'title' => 'Message',
                        'value' => $exception->getMessage(),
                        'short' => true
                    ]),
                    new AttachmentField([
                        'title' => 'File',
                        'value' => $exception->getFile() . ':' . $exception->getLine(),
                        'short' => true
                    ]),

                    new AttachmentField([
                        'title' => 'Request',
                        'value' => app('request')->getRequestUri(),
                        'short' => true
                    ]),
                    new AttachmentField([
                        'title' => 'Timestamp',
                        'value' => Carbon::now()->toDateTimeString(),
                        'short' => true
                    ]),
                    new AttachmentField([
                        'title' => 'User',
                        'value' => auth()->check() ? auth()->user()->utorid : 'Not logged in',
                        'short' => true
                    ])
                ]
            ]);

            Slack::to($config['channel'])->from($config['username'])->attach($attachment)->withIcon($config['icon'])->send($message);
        } catch (\Exception $e)
        {
            $str = $e->getFile()." Line: ".$e->getLine()." " .$e->getMessage(). "\n".$e->getTraceAsString();
            Log::error($str);
        }
    }

}