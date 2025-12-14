<?php

use App\Core\Env;

return [
    'paths' => [
        'migrations' => __DIR__ . '/../mysql/migrations',
        'seeds' => __DIR__ . '/../mysql/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',    
        'default_environment' => 'development',

        'production' => [
            'adapter' => 'mysql',
            'host' => Env::get('DB_HOST', '127.0.0.1'),
            'name' => Env::get('DB_DATABASE', 'production_db'),
            'user' => Env::get('DB_USERNAME', 'root'),
            'pass' => Env::get('DB_PASSWORD', ''),
            'port' => Env::get('DB_PORT', 3306),
            'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
            'collation' => Env::get('DB_COLLATION', 'utf8mb4_unicode_ci'),
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => Env::get('DB_HOST', '127.0.0.1'),
            'name' => Env::get('DB_DATABASE', 'development_db'),
            'user' => Env::get('DB_USERNAME', 'root'),
            'pass' => Env::get('DB_PASSWORD', ''),
            'port' => Env::get('DB_PORT', 3306),
            'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
            'collation' => Env::get('DB_COLLATION', 'utf8mb4_unicode_ci'),
        ],

        'testing' => [
            'adapter' => 'mysql',
            'host' => Env::get('DB_HOST', '127.0.0.1'),
            'name' => Env::get('DB_DATABASE', 'testing_db'),
            'user' => Env::get('DB_USERNAME', 'root'),
            'pass' => Env::get('DB_PASSWORD', ''),
            'port' => Env::get('DB_PORT', 3306),
            'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
            'collation' => Env::get('DB_COLLATION', 'utf8mb4_unicode_ci'),
        ]
    ],
    'version_order' => 'creation'
];
