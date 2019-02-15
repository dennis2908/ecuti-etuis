<?php

namespace LaravelExceptionNotification\Drivers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class MailDriver implements DriverInterface
{

    /**
     * It sends e-mail notification for a given exception.
     *
     * @param \Exception $exception
     */
    public function send(\Exception $exception)
    {
        $config = config('exception-notification.mail');
        try {
            Mail::send('laravel-exception-notification::email', ['e' => $exception], function ($m) use ($config) {
                $m->from($config['from']);
                $m->to($config['to']);
                $m->subject('A exception has been thrown on ' . config('app.url'));
            });
        }catch (\Exception $e)
        {
            $str = $e->getFile()." Line: ".$e->getLine()." " .$e->getMessage(). "\n".$e->getTraceAsString();
            Log::error($str);
        }
    }
}