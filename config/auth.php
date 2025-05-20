<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'dosen' => [
            'driver' => 'session',
            'provider' => 'dosens',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'dosens' => [
            'driver' => 'eloquent',
            'model' => App\Models\Dosen::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
