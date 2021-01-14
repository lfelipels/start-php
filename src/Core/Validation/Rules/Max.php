<?php

namespace App\Core\Validation\Rules;

use App\Core\Validation\Rules\RuleInterface;
use App\Core\Validation\ValidationException;

class Max implements RuleInterface
{
    /**
     * @param string $input
     * @param array $value
     * @param string $message
     * @throws ValidationException
     * @return boolean
     */
    public function check(string $input, $value, string $message): bool
    {
        if(!is_array($value) || !filter_var($value[0], FILTER_VALIDATE_INT)){
            throw new \InvalidArgumentException('Invalid max validation rule. exemple rule: max:number(int)');
        }
        if (mb_strlen($value[1]) > $value[0]) {
            throw new ValidationException($message);
        }
        return true;
    }
}
