<?php

namespace App\Exceptions;

use Exception;

class HttpRouteException extends BaseException
{
    public static function routeNotFound()
    {
        return new self(
            'Not found!',
            '404'
        );
    }

    public static function methodNotAllowed()
    {
        return new self(
            'Route method not allowed!',
            '405'
        );
    }
}
