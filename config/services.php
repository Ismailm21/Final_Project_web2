<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
         'client_id' => '257329477960-udoj6vg93232k714j3sb2cd9l797bkir.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],

      'facebook' => [
    'client_id' => '1030748305260575',
    'client_secret' => 'e22497b751ce9e20b4b74bc1b2d8ac81',
    'redirect' => 'http://127.0.0.1:8000/auth/facebook/callback',
]

];
