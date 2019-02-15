<?php

namespace LaravelExceptionNotification;

use LaravelExceptionNotification\ExceptionNotification;
use Illuminate\Support\ServiceProvider;

class ExceptionNotificationServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/exception-notification.php' => config_path('exception-notification.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-exception-notification');
    }


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/exception-notification.php', 'exception-notification');
        $this->app->singleton('exception-notification', function () {
            return new ExceptionNotification;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'exception-notification' ];
    }
}