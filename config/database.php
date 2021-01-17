<?php

return [
    'default' => 'pgsql',
    'connections' => [
        'pgsql' =>  [
            'driver' => 'pgsql', //drivers suported: pgsql, mysql and slqlite
            'host' => 'localhost',
            'database' => 'posts',
            'username' => 'postgres',
            'password' => '123',
            'port' => '5432',
        ],
        
        'mysql' =>  [
            'driver' => 'mysql', //drivers suported: pgsql, mysql and slqlite
            'host' => 'localhost',
            'database' => 'posts',
            'username' => 'root',
            'password' => '123',
            'port' => '',
        ],

        'sqlite' =>  [
            'driver' => 'sqlite', //drivers suported: pgsql, mysql and slqlite
            'database' => '',
        ]
    ]
];