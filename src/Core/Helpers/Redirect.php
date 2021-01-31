<?php

namespace App\Core\Helpers;

use App\Core\Http\Request;
use App\Core\Session\FlashMessage;
use App\Core\Validation\ErrorValidation;

class Redirect
{
    public static function to(string $url)
    {
        return header('Location:'. $url);
    }
    
    /**
     * Add data as flash message
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public static function with(string $key, $value)
    {
        (new FlashMessage)->set($key, $value);
        return new static;
    }

    public static function withErrors(array $errors)
    {
        (new FlashMessage)->set('errors', new ErrorValidation($errors));
        return new static;
    }
    
    public static function back()
    {
        $request = new Request();
        $dados = $request->getServer();
        return header('Location:'. $dados['HTTP_REFERER']);
    }
}
