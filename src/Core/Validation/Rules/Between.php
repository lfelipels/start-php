<?php

namespace App\Core\Validation\Rules;

use App\Core\Validation\ValidationException;

class Between implements RuleInterface
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
        if(!is_array($value) || strpos($value[0], ',') === false){
            throw new \InvalidArgumentException('Invalid between validation rule. exemple between: between:value1,value2');
        }

        $betweenValues = explode(',', $value[0]);
        
        if($value[1] < $betweenValues[0] || $value[1] > $betweenValues[1]){
            throw new ValidationException($message);
        }

        return true;
    }
}
