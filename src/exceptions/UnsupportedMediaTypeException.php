<?php

namespace exceptions;

require_once 'AppException.php';

class UnsupportedMediaTypeException extends AppException
{
    public function __construct(string $message = "Unsupported media type uploaded")
    {
        parent::__construct($message, 415);
    }
}
