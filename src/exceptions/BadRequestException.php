<?php

namespace exceptions;

require_once 'AppException.php';

class BadRequestException extends AppException
{
    public function __construct(string $message = "Bad request, please check the sent request")
    {
        parent::__construct($message, 400);
    }
}
