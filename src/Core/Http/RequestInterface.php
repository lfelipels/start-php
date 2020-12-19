<?php

namespace App\Core\Http;

interface RequestInterface
{
    public function getServer(): array;
    public function getURI(): string;
    public function getMethod(): string;
    public function getBody(): array;
    // public function getParams(): string;
    // public function getHeaders(): array;
    // public function addHeaders(): array;
}
