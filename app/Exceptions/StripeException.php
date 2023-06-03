<?php

namespace App\Exceptions;

use Exception;

class StripeException extends BaseException
{
    public static function errorMessage($message, $code)
    {
        return new self(
            $message,
            $code
        );
    }
}
