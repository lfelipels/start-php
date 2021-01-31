<?php

namespace App\Core\Helpers;

class Env
{
    public static function get(string $name, string $default = '')
    {
        return $_ENV[$name] ?? $default;
    }
}
