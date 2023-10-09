<?php

namespace exceptions;

require_once 'AppException.php';

class UnauthenticatedException extends AppException
{
    public function __construct(string $message = "Not yet authenticated, please log in")
    {
        parent::__construct($message, 401);
    }
}
