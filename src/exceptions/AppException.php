<?php

namespace exceptions;

class AppException extends \Exception {
    public function __construct(string $message = 'Internal server error', int $code = 500) {
        parent::__construct($message, $code);
        $this->message = "$message";
        $this->code = $code;
    }
}