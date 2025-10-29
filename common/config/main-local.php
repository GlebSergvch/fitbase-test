<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=db;dbname=fitbase',
            'username' => 'fitbase_user',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
        'db-test' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('TEST_DB_DSN') ?: 'mysql:host=db;dbname=fitbase_test',
            'username' => env('TEST_DB_USERNAME') ?: 'fitbase_user',
            'password' => env('TEST_DB_PASSWORD') ?: 'secret',
            'charset' => 'utf8mb4',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            // You have to set
            //
            // 'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
            //    'transport' => [
            //        'scheme' => 'smtps',
            //        'host' => '',
            //        'username' => '',
            //        'password' => '',
            //        'port' => 465,
            //        'dsn' => 'native://default',
            //    ],
            //
            // DSN example:
            //    'transport' => [
            //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
