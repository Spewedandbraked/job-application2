<?php

use App\Core\Env;

return [
    'default' => Env::get('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver'    => 'pdo_mysql',
            'host'      => Env::get('DB_HOST', '127.0.0.1'),
            'port'      => Env::get('DB_PORT', 3306),
            'dbname'    => Env::get('DB_DATABASE', 'forge'),
            'user'      => Env::get('DB_USERNAME', 'forge'),
            'password'  => Env::get('DB_PASSWORD', ''),
            'charset'   => Env::get('DB_CHARSET', 'utf8mb4'),
            'defaultTableOptions' => [
                'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
                'collate' => Env::get('DB_COLLATION', 'utf8mb4_unicode_ci'),
            ],
        ],

        'sqlite' => [
            'driver'    => 'pdo_sqlite',
            'path'      => __DIR__ . '/../database.sqlite',
        ],

        'pgsql' => [
            'driver'    => 'pdo_pgsql',
            'host'      => Env::get('DB_HOST', '127.0.0.1'),
            'port'      => Env::get('DB_PORT', 5432),
            'dbname'    => Env::get('DB_DATABASE', 'forge'),
            'user'      => Env::get('DB_USERNAME', 'forge'),
            'password'  => Env::get('DB_PASSWORD', ''),
            'charset'   => Env::get('DB_CHARSET', 'utf8'),
        ],
    ],
];
