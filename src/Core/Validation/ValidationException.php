<?php

namespace App\Core\Validation;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $message, $code = 422)
    {
        parent::__construct($message, $code);
    }
}
