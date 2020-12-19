<?php
namespace App\Core\Http;
use App\Core\Http\RequestInterface;

class Request implements RequestInterface
{
    public function getServer(): array
    {
        return $_SERVER;
    }

    public function getURI(): string
    {
        return trim(strtolower($this->getServer()['REQUEST_URI']));
    }
    
    public function getMethod(): string
    {
        return strtoupper($this->getServer()['REQUEST_METHOD']);        
    }

    public function getBody(): array
    {
        $data = $this->getMethod() === 'POST' ? $_POST : $_GET;
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $_POST = [];
        $_GET = [];
        $_REQUEST = [];
        return $data;
    }
}

