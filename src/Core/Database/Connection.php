<?php

namespace App\Core\Database;

use PDO;
use App\Core\Database\ConnectionInterface;

class Connection implements ConnectionInterface
{
    private static $connection;

    public static function getInstance(string $connetionName = 'default'): PDO
    {
        if(!self::$connection){
            try {
                self::$connection = new PDO(
                    'pgsql:host=localhost;dbname=posts;port=5432',
                    'postgres',
                    '123',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]
                );
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        return self::$connection;
    }
}
