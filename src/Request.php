<?php

namespace App;

use App\Helper\StringHelper;

class Request
{
    public function __construct(private readonly array $data)
    {
        foreach ($data as $key => $element) {
            $data[$key] = StringHelper::cleanString($element);
        }
    }

    public function get(string $key): ?string
    {
        return isset($this->data[$key]) ?: null;
    }

    public function getData(): array
    {
        return $this->data;
    }
}