<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => \App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'cdn' => [
        'secure' => env('CDN_HTTPS', '/assets'),
        'insecure' => env('CDN_HTTP', '/assets'),
        'default' => env('CDN_DEFAULT', '/assets'),
	],

    'cloudflare' => [
        'email' => env('CLOUDFLARE_EMAIL'),
        'secret' => env('CLOUDFLARE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_REDIRECT'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],

    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_REDIRECT'),
    ],

    'rollbar' => array(
        'access_token' => env('ROLLBAR_TOKEN'),
        'level' => env('ROLLBAR_DEBUG_LVL', 'error'),
    ),

    'slack' => array(
        'members' => env('SLACK_MEMBERS_TOKEN'),
        'have' => env('SLACK_HAVE_TOKEN'),
        'want' => env('SLACK_WANT_TOKEN'),
    ),

];
