<?php
return [
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI')
    ],

    'ses' => [
        'key' => env('MAIL_USERNAME'),
        'secret' => env('MAIL_PASSWORD'),
        'region' => 'sa-east-1',
        'options' => [
            'ConfigurationSetName' => 'TrackingEmail',
        ],
    ],
];
