<?php

namespace App\Core\Database;

use PDO;
use App\Core\Database\ConnectionInterface;
use App\Core\Exception\DatabaseConnectionException;
use App\Helpers\Config;
class Connection implements ConnectionInterface
{
    private static $connection;

    private static function getConfig(?string $connectionName = null): array
    {
        $connectionName ??= Config::get('database.default');
        try {
            $config = Config::get("database.connections.{$connectionName}");
            return $config;
        } catch (\InvalidArgumentException $e) {
            throw new DatabaseConnectionException("Connection {$connectionName} not found.");
        }
    }

    public static function getInstance(?string $connectionName = null): PDO
    {
        if(!self::$connection){
            try {
                $config = self::getConfig($connectionName);
                $dns = sprintf(
                    '%s:host=%s;dbname=%s;port=%s',
                    $config['driver'],
                    $config['host'],
                    $config['database'],
                    $config['port']
                );

                self::$connection = new PDO(
                    $dns,
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]
                );
            } catch (\Throwable $th) {
                throw new DatabaseConnectionException('Connection database failed');
            }
        }
        
        return self::$connection;
    }
}
