<?php

namespace Orm\Exceptions;

class NotFoundException extends Exception
{
    public function __construct($message = '', $code = 0)
    {
        $message = $message ? : 'this model is not found';
        $code = $code ? : 404;
        parent::__construct($message, $code);
    }
}
