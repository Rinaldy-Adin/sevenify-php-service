<?php

namespace exceptions;

abstract class AppException extends \Exception {
    public function __construct(string $message = '', int $code = 500) {
        parent::__construct($message, $code);
        $this->message = "$message";
        $this->code = $code;
    }
}