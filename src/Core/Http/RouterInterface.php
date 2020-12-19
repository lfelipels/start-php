<?php

namespace App\Core\Http;


interface RouterInterface
{
    /**
     * Get route lists
     *
     * @return array
     */
    public function getRoutes(): array;
    public function getGroups(): array;

    /**
     * Register a route
     *
     * @param string $method HTTP Method
     * @param string $uri
     * @param array|\Closure $callback
     * @return void
     */
    public function addRoute(string $method, string $uri, $callback): RouterInterface;
    public function name(string $name): RouterInterface;
    public function group(string $name, \Closure $callback): void;
}
