<?php

namespace LaravelExceptionNotification;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

class NotificationExceptionHandler extends ExceptionHandler
{
    
    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     *
     */
    public function report(Exception $e)
    {
        foreach ($this->dontReport as $type) {
            if ($e instanceof $type) {
                return parent::report($e);
            }
        }

        if (app()->bound('exception-notification')) {
            app('exception-notification')->notifyException($e);
        }

        return parent::report($e);
    }
}