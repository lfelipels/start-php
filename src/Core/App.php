<?php

namespace App\Core;

use App\Core\Http\RequestInterface;
use App\Core\Http\Route;
use App\Core\Http\RouterInterface;
use App\Core\Http\Traits\WithRouteURI;
use Exception;

class App
{
    /** Traits */
    use WithRouteURI;

    /** Properts */
    private $router;
    private $request;

    /**
     * Class constructor.
     */
    public function __construct(RequestInterface $request, RouterInterface $router)
    {
        $this->request = $request;
        $this->router = $router;
    }

    private function resolveRoute()
    {
        $routes = $this->router->getRoutes()[$this->request->getMethod()] ?? [];
        $routeFound = array_filter($routes, fn (Route $route) => $this->checkRouteURI($route->uri(), $this->request->getURI()));
        $routeFound = $routeFound[array_key_first($routeFound)] ?? null;
        if (!$routeFound) {
            http_response_code(404);
            throw new Exception("Página {$this->request->getURI()} não encontrada.", 404);
        }

        $callback = $routeFound->callback();
        if (is_array($callback)) {
            $callback = array(new $callback[0], $callback[1]);
        }
        
        echo call_user_func($callback, $this->request, $this->paramsURI);
    }

    public function run()
    {
        $this->resolveRoute();
    }
}
