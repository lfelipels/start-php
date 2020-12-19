<?php

namespace App\Core\Session;

interface SessionInterface
{
    /**
     * chech if a key exists in session
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * Set value in session
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set(string $key, $value): void;

    /**
     * get value in session
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
    
    /**
     * Return all data session
     *
     * @return array
     */
    public function all(): array;
    public function remove(string $key): bool;
    public function clear(): void;
}
