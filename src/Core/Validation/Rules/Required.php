<?php

namespace App\Core\Validation\Rules;

use App\Core\Validation\ValidationException;

class Required implements RuleInterface
{
    /**
     * Chech input value is required
     *
     * @param string $input
     * @param string $value
     * @param string $message
     * @throws ValidationException
     * @return boolean
     */
    public function check(string $input, $value, string $message): bool
    {
        if (empty($value)) {
            throw new ValidationException($message);
        }
        return true;
    }
}
