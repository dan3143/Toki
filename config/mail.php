<?php

return [

   

    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.googlemail.com'),

    'port' => env('MAIL_PORT', 465),


    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'tokiunapp@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Toki'),
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
    'stream' => [
        'ssl' => [
           'allow_self_signed' => true,
           'verify_peer' => false,
           'verify_peer_name' => false,
        ],
     ],


    'username' => env('tokiunapp@gmail.com'),

    'password' => env('capacho2019'),


    'sendmail' => '/usr/sbin/sendmail -bs',

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],



    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
