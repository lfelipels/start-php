<?php

namespace App\Core\Session;

class FlashMessage
{
    private $session;
    protected const FLASSH_KEY = 'flash_messages';

    public function __construct()
    {
        $this->session = Session::make();
        if (!$this->session->has(self::FLASSH_KEY)) {
            $this->session->set(self::FLASSH_KEY, []);
        }
    }

    private function getFlashes(): array
    {
        return $this->session->get(self::FLASSH_KEY);
    }

    public function set(string $key, string $message): void
    {
        $this->session->set(self::FLASSH_KEY, array_merge(
            $this->getFlashes(),
            [$key => $message]
        ));
    }
    
    public function get(string $key)
    {
        $flashes = $this->getFlashes();
        $value = null;
        if (isset($flashes[$key])) {
            $value = $flashes[$key];
            unset($flashes[$key]);
            $this->session->set(self::FLASSH_KEY, $flashes);
        }
        return $value;
    }

    public function has(string $key): bool
    {
        $flashes = $this->getFlashes();
        return isset($flashes[$key]);
    }
}
