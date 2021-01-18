<?php

namespace App\Core\Validation;

class ErrorValidation
{
    private array $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function get(string $input, string $rule)
    {
        return $this->errors[$input][$rule] ?? '';
    }
    
    public function first(string $input)
    {
        if(!$this->has($input)) return '';

        $rules = $this->errors[$input];
        $message = $rules[array_key_first($rules)] ?? '';
        return $message;
    }
    
    public function has(string $input)
    {
        return isset($this->errors[$input]);
    }


    public function all(): array
    {
        $messages = array_reduce(
            $this->errors,
            function ($messages, $inputRules) {
                foreach ($inputRules as $rule => $message) {
                    $messages[] = $message;
                }

                return $messages;
            },
            []
        );

        return $messages;
    }
}
