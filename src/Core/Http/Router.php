<?php

namespace App\Core\Http;

use App\Core\Http\RouterInterface;
use App\Core\Http\Route;
use App\Core\Http\Traits\WithRouteURI;

class Router implements RouterInterface
{
    use WithRouteURI;

    private array $routes;
    private array $groups;
    private ?Route $currentRouteAdded;
    private string $groupName;

    public function __construct(string $defaultGroup = 'web')
    {
        $this->routes = [];
        $this->currentRouteAdded = null;
        
        $this->makeRouteGroup($defaultGroup);
    }

    private function makeRouteGroup(string $name, $prefix = ''): void
    {
        $this->groupName = trim(strtolower($name));
        $this->groups[$name]['prefix'] = $prefix;
        $this->groups[$name]['middlewares'] = [];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function name(string $name): RouterInterface
    {
        return $this;
    }    

    public function group(string $name, \Closure $callback): void
    {
        $this->makeRouteGroup($name);
        $callback($this);
    }

    public function addRoute(string $method, string $uri, $callback): RouterInterface
    {
        $route = new Route($this->groupName, $method, $uri, $callback);
        $this->routeAlreadyExists($route);
        $this->routes[$route->method()][] = $route;
        $this->currentRouteAdded = $route;
        return $this;
    }

    private function routeAlreadyExists(Route $route)
    {
        $hasMethod = $this->routes[$route->method()] ?? false;
        if(!empty($this->routes) && $hasMethod !== false){
            $exists = array_filter($this->routes[$route->method()], fn($r) => $this->checkRouteURI($r->uri(), $route->uri()));
            if(!empty($exists)){
                throw new \InvalidArgumentException("Route {$route->uri()} already exists");
            }
        }
    }

    public function get(string $uri, $callback): RouterInterface
    {
        return $this->addRoute('get', $uri, $callback);
    }

    public function post(string $uri, $callback): RouterInterface
    {
        return $this->addRoute('post', $uri, $callback);
    }

    public function put(string $uri, $callback): RouterInterface
    {
        return $this->addRoute('put', $uri, $callback);
    }

    public function delete(string $uri, $callback): RouterInterface
    {
        return $this->addRoute('delete', $uri, $callback);
    }
}
