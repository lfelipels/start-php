<?php

namespace App\Core\Database;

use PDO;
use App\Core\Database\ConnectionInterface;
use App\Core\Exception\DatabaseConnectionException;
use App\Helpers\Config;
use App\Helpers\Env;

class Connection implements ConnectionInterface
{
    private static $connection;

    private static function getConfig(?string $connectionName = null): array
    {
        $default = Env::get('DB_CONNECTION') ?? Config::get('database.default');
        $connectionName ??= $default;

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
                self::$connection = self::make($config);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (\Throwable $th) {
                throw new DatabaseConnectionException('Connection database failed');
            }
        }
        
        return self::$connection;
    }

    public static function make(array $config): PDO
    {

        switch ($config['driver']) {
            case 'sqlite':
                $dns = sprintf("%s:%s", $config['driver'], $config['database']);
                return new PDO(
                    $dns, "","",array(
                        PDO::ATTR_PERSISTENT => true
                    )
                );
                break;
            
            default:
                $dns = sprintf(
                    '%s:host=%s;dbname=%s;port=%s',
                    $config['driver'],
                    $config['host'],
                    $config['database'],
                    $config['port']
                );
        
                return new PDO($dns, $config['username'], $config['password']);
                break;
        }        
    }
}
