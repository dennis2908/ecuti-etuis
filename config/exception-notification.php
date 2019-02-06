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
    'environments' => [ 'production' ],

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
        'from' => 'e-tuis@jheks.gov.my',
        'to'   => env('EXCEPTION_EMAIL', '')
    ],

    /*
     * Uses maknz\slack package.
     */
    'slack'        => [
        'channel'  => '#errors',
        'username' => 'Exception Notification',
        'icon'     => ':robot_face:',
    ],
];
