<?php

namespace exceptions;

require_once 'AppException.php';

class NotFoundException extends AppException
{
    public function __construct(string $message = "Request url not found")
    {
        parent::__construct($message, 404);
    }
}
