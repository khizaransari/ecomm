<?php

namespace App\Exceptions;

use Exception;

class RequestValidationException extends BaseException
{
    public static function errorMessage($message)
    {
        return new self(
            $message,
            '422'
        );
    }
}
