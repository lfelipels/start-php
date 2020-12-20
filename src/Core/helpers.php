<?php

use App\Core\App;
use App\Core\Session\FlashMessage;
use App\Core\Session\Session;

if (!function_exists('dd')) {
    function dd($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        die();
    }
}

if (!function_exists('flash')) {
    function flash()
    {
        return new FlashMessage;
    }
}

if (!function_exists('session')) {
    function session()
    {
        return app()->session();
    }
}

if (!function_exists('app')) {
    function app()
    {
        return App::instance();
    }
}
