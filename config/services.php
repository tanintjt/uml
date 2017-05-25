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

    /*'google' => [
        'client_id' => '1002834424038-u8gq1dv82faokiidqmkerup2v8tjhhhr.apps.googleusercontent.com',
        'client_secret' => '2jNuzmKiBZk0Wx_G6BWixrpz',
        'redirect' => 'http://localhost/uml/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '247886175618536',
        'client_secret' => '8bb937636905658b8a745116bfd0ba98',
        'redirect' => 'http://localhost/uml/auth/facebook/callback',
    ],*/

    'google' => [
        'client_id' => '530525152810-ilqg16okr1msfp9ftqkuk9o0ftf5altj.apps.googleusercontent.com',
        'client_secret' => 'qJhjsPpu9g5mJwmpyTNFt_iL',
        'redirect' => 'http://localhost/uml/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '352095025188304', 
        'client_secret' => '86ebb7751a9b1dcbfe1eee3af900a554',
        'redirect' => 'http://localhost/uml/auth/facebook/callback',
    ],

];
