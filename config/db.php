<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => sprintf('mysql:host=%s;port=%s;dbname=%s', env('DB_HOST'), env('DB_PORT'), env('DB_NAME')),
    'username' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
