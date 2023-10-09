<?php

namespace exceptions;

require_once 'AppException.php';

class ForbiddenException extends AppException
{
    public function __construct(string $message = "User forbidden")
    {
        parent::__construct($message, 403);
    }
}
