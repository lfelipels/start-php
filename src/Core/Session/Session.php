<?php

namespace App\Core\Session;

use App\Core\Session\SessionInterface;

class Session implements SessionInterface
{
    private function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function make(): self
    {
        return new static;
    }

    /**
     * chech if a key exists in session
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool
    {
        return isset($this->all()[$key]);
    }

    /**
     * Set value in session
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * get value in session
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->has($key) ?  $this->all()[$key] : null;
    }

    /**
     * Return all data session
     *
     * @return array
     */
    public function all(): array
    {
        return $_SESSION ?? [];
    }

    public function remove(string $key): bool {
        if(!$this->has($key)){
            return false;
        }        
        unset($_SESSION[$key]);
        return true;
    }
    
    public function clear(): void {
        $_SESSION = [];
    }
}
