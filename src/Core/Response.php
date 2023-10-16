<?php

namespace App\Core;

class Response {
    private mixed $content;
    private mixed $statusCode;
    private mixed $headers;

    public function __construct($content = '', $statusCode = 200, $headers = []) {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->content;
    }
}