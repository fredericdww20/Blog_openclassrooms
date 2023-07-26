<?php

namespace App;

use App\Helper\StringHelper;

class Request
{
    public function __construct(private readonly array $data)
    {
        foreach ($data as $key => $element) {
            $data[$key] = StringHelper::cleanString($element, true);
        }
    }

    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}