<?php

namespace App\Helpers;

class Path
{

    public static function root()
    {
        return dirname(__DIR__, 2);
    }
    
    public static function app()
    {
        return self::root() . "/src/";
    }
    
    public static function storage()
    {
        return self::root() . "/storage/";
    }
    
    public static function public()
    {
        return self::root() . "/public/";
    }
    
    public static function views()
    {
        return self::root() . "/views/";
    }
    
    public static function database()
    {
        return self::root() . "/database/";
    }
}
