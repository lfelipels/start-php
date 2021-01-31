<?php

use App\Core\Helpers\Env;
use App\Core\Helpers\Path;

return [
    'default' => 'pgsql',
    'connections' => [
        'pgsql' =>  [
            'driver' => Env::get('DB_DRIVER', 'pgsql'), //drivers suported: pgsql, mysql and slqlite
            'host' => Env::get('DB_HOST', 'localhost'),
            'database' => Env::get('DB_NAME', 'db_example'),
            'username' => Env::get('DB_USERNAME', 'username'),
            'password' => Env::get('DB_PASSWORD'),
            'port' => Env::get('DB_PORT', '5432'),
        ],
        
        'mysql' =>  [
            'driver' => Env::get('DB_DRIVER', 'mysql'), //drivers suported: pgsql, mysql and slqlite
            'host' => Env::get('DB_HOST', 'localhost'),
            'database' => Env::get('DB_NAME', 'db_example'),
            'username' => Env::get('DB_USERNAME', 'root'),
            'password' => Env::get('DB_PASSWORD'),
            'port' => Env::get('DB_PORT', '3306'),
        ],

        'sqlite' =>  [
            'driver' => Env::get('DB_DRIVER', 'sqlite'), //drivers suported: pgsql, mysql and slqlite
            'database' => Env::get('DB_NAME', Path::database() . '/database.sqlite'),
        ]
    ]
];