<?php

namespace App\Helpers;

use Psr\Http\Message\ResponseInterface;

class Redirect
{
    public static function to(string $url)
    {
        return header('Location:'. $url);
    }
}
