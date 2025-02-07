<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'adminlog' => [
            'driver' => 'single',
            'path' => storage_path('logs/admin.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],

        'paymentslog' => [
            'driver' => 'single',
            'path' => storage_path('logs/payments.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'qiwi' => [
            'driver' => 'single',
            'path' => storage_path('logs/qiwi.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'enot' => [
            'driver' => 'single',
            'path' => storage_path('logs/enot.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'freekassa' => [
            'driver' => 'single',
            'path' => storage_path('logs/freekassa.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'primepayments' => [
            'driver' => 'single',
            'path' => storage_path('logs/primepayments.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'pagseguro' => [
            'driver' => 'single',
            'path' => storage_path('logs/pagseguro.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'paymentwall' => [
            'driver' => 'single',
            'path' => storage_path('logs/paymentwall.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
        'paypal' => [
            'driver' => 'single',
            'path' => storage_path('logs/paypal.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],


        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
