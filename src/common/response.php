<?php

namespace common;

class Response {
    public int $statusCode;
    public array $headers;
    public array $data;

    public function __construct($data = '', $statusCode = 200, $headers = []) {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->data = $data;
    }

    public function httpResponse(): string {
        http_response_code($this->statusCode);

        // Set the response headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        $body = [
            "status" => floor($this->statusCode / 100) == 2 ? "success" : "fail",
            "data" => $this->data
        ];

        // Send the response body
        return json_encode($body);
    }
}