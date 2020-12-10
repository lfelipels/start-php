<?php

namespace App\Core\Database;

interface ConnectionInterface
{
    public static function getInstance(string $connetionName = 'default'): \PDO;
}
