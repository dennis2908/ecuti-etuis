<?php

namespace LaravelExceptionNotification;

class ExceptionNotification
{

    /**
     * It calls all enabled drivers and triggers requests to send notifications.
     *
     * @param \Exception $e
     */
    public function notifyException(\Exception $e)
    {
        $driver = config('exception-notification.drivers');

        if ($this->enabledEnvironment(app()->environment())) {
            if (is_array($driver)) {
                foreach ($driver as $instance) {
                    $this->sendException($e, $instance);
                }
            } else {
                $this->sendException($e, $driver);
            }
        }
    }


    /**
     * It sends notification to given driver.
     *
     * @param \Exception $e
     * @param            $driver
     */
    protected function sendException(\Exception $e, $driver)
    {
        $channel = $this->getDriverInstance($driver);
        $channel->send($e);
    }


    /**
     * It injects driver's class to Laravel application.
     *
     * @param $driver
     *
     * @return mixed
     */
    protected function getDriverInstance($driver)
    {
        $class = 'LaravelExceptionNotification\Drivers\\' . ucfirst($driver) . 'Driver';

        return app($class);
    }


    /**
     * Check if given environment is enabled in configuration file.
     *
     * @param $environment
     *
     * @return mixed
     */
    public function enabledEnvironment($environment)
    {
        $config = config('exception-notification.environments');

        if (is_array($config)) {
            return in_array($environment, config('exception-notification.environments'));
        }

        return $environment === $config;
    }

}
