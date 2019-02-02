<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' =>      '219121025450504',
        'client_secret' =>  '2c91b202d04feccf6d98dfdf88818176',
        'redirect' =>       'https://www.shoptizer.com/callback',
    ],

    'google' => [
        'client_id' =>      '866171999408-hr3summgriripr3btgbmdeoap6lh9l8q.apps.googleusercontent.com',
        'client_secret' =>  '98xtaDRmMSO7ofMk-Jsd8Jvp',
        'redirect' =>       'https://www.shoptizer.com/callback/google',
    ],
];
