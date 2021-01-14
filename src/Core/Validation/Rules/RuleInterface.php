<?php

namespace App\Core\Validation\Rules;

use Core\Validation\ValidationException;

interface RuleInterface
{
    /**
     * Chech input rule
     *
     * @param string $input
     * @param mixed $value
     * @param string $message
     * @throws ValidationException
     * @return boolean
     */
    public function check( string $input, $value, string $message): bool;
}
