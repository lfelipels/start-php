<?php

namespace App\Core\Http;

class Route {
    private string $uri;
    private string $method;
    private string $group;
    private ?string $name;
    /** @var array|\Closure */
    private $callback;

    public function __construct(string $group, string $method, string $uri, $callback, ?string $name = null)
    {
        $this->assertMethod($method);
        $this->assertCallback($callback);
        $this->uri = trim(strtolower($uri));
        $this->method = trim(strtoupper($method));
        $this->callback = $callback;
        $this->name = $name;
    }

    private function assertMethod(string $method)
    {
        if (!in_array(strtoupper($method), ['POST', 'GET', 'PUT', 'DELETE'])) {
            throw new \InvalidArgumentException('Invalid http method ' . $method);
        }
    }

    private function assertCallback($callback)
    {
        if (!is_array($callback) && !is_callable($callback)) {
            throw new \InvalidArgumentException("Invalid callback. It's should an array or a Closure type");
        }

        if (is_array($callback) && count($callback) !== 2) {
            throw new \InvalidArgumentException("Invalid callback. Define a valid class name in the first index and a valid class method in the second index.");
        }
    }

    public function uri()
    {
        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function group(): string
    {
        return $this->group;
    }

    public function name(): ?string
    {
        return $this->name;
    }
    
    /** @return array|\Closure */
    public function callback()
    {
        return $this->callback;
    }
}
