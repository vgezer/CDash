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
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/auth/github/callback',
        'enable' => env('GITHUB_ENABLE', false),
        'autoregister' => env('GITHUB_AUTO_REGISTER_NEW_USERS', false),
        'oauth' => true,
        'display_name' => 'GitHub',
    ],
    'gitlab' => [
        'client_id' => env('GITLAB_CLIENT_ID'),
        'client_secret' => env('GITLAB_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/auth/gitlab/callback',
        'instance_uri' => env('GITLAB_DOMAIN'),
        'enable' => env('GITLAB_ENABLE', false),
        'autoregister' => env('GITLAB_AUTO_REGISTER_NEW_USERS', false),
        'oauth' => true,
        'display_name' => 'GitLab',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'hosted_domain' => '*',
        'redirect' => env('APP_URL').'/auth/google/callback',
        'enable' => env('GOOGLE_ENABLE', false),
        'autoregister' => env('GOOGLE_AUTO_REGISTER_NEW_USERS', false),
        'oauth' => true,
        'display_name' => 'Google',
    ],

    'pingidentity' => [
        'client_id' => env('PINGIDENTITY_CLIENT_ID'),
        'client_secret' => env('PINGIDENTITY_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/auth/pingidentity/callback',
        'instance_uri' => env('PINGIDENTITY_DOMAIN'),
        'enable' => env('PINGIDENTITY_ENABLE', false),
        'autoregister' => env('PINGIDENTITY_AUTO_REGISTER_NEW_USERS', false),
        'oauth' => true,
        'display_name' => 'PingIdentity',
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
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
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

];
