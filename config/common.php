<?php

declare(strict_types=1);

$db = require __DIR__ . '/db.php';

return [
    'bootstrap' => ['log', 'queue'],
    'basePath' => dirname(__DIR__),
    'components' => [
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => env('REDIS_HOSTNAME'),
            'port' => (int)env('REDIS_PORT'),
            'database' => (int)env('REDIS_DATABASE'),
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'channel' => 'queue',
        ],
        'cache' => [
            'class' => \yii\redis\Cache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ]
];
