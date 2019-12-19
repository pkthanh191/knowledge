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
        'region' => 'us-east-1',
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
        'client_id' => '2062748274001660',
        'client_secret' => 'c5167dc45a47ed691a9a82a49d998320',
        'redirect' => env('APP_HTTPS_URL').'/callback-facebook',
    ],
    'google' => [
        'client_id' => '412196338955-qconq65p769eqg2bt3e6a17i1357140a.apps.googleusercontent.com',
        'client_secret' => 'lsDIlFEW0b-aNu2RDaWJ0lxa',
        'redirect' => env('APP_URL').'/callback-google',
    ],
];