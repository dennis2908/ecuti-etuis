<?php

namespace LaravelExceptionNotification\Drivers;

interface DriverInterface
{
    public function send(\Exception $exception);
}