<?php

namespace App\Core\Validation\Rules;

use App\Core\Validation\ValidationException;

class Equals implements RuleInterface
{
    /**
     * Chech input value is required
     *
     * @param string $input
     * @param array $value
     * @param string $message
     * @throws ValidationException
     * @return boolean
     */
    public function check(string $input, $value, string $message): bool
    {
        if(!is_array($value)){
            throw new \InvalidArgumentException('Invalid equals validation rule. exemple equals: equals:otherinput');
        }
        if ($value[1] !== $value[0]) {
            throw new ValidationException($message);
        }
        return true;
    }
}
