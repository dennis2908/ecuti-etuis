<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Enabled sender drivers
     |--------------------------------------------------------------------------
     |
     | Send a notification about exception in your application to supported channels.
     |
     | Supported: "mail", "slack". You can use multiple drivers.
     |
     */
    'drivers'      => [ 'slack' ],

    /*
     |--------------------------------------------------------------------------
     | Enabled application environments
     |--------------------------------------------------------------------------
     |
     | Set environments that should generate notifications.
     |
     */
    'environments' => [ 'staging','production','local' ],

    /*
     |--------------------------------------------------------------------------
     | Mail Configuration
     |--------------------------------------------------------------------------
     |
     | It uses your app default Mail driver. You shouldn't probably touch the view
     | property unless you know what you're doing.
     |
     */
    'mail'         => [
        'from' => 'non-reply@utoronto.ca',
        'to'   => env('EXCEPTION_EMAIL')
    ],

    /*
     * Uses maknz\slack package.
     */
    'slack'        => [
        'channel'  => '#it-application-logs',
        'username' => 'Exception Notification',
        'icon'     => ':robot_face:',
    ],
];
