<?php

namespace App;

use App\Helper\StringHelper;

class Request
{
    public function __construct(private readonly array $data)
    {
        foreach ($data as $key => $element) {
            if (is_string($element)) {
                $data[$key] = StringHelper::cleanString($element, true);
            } else {
                $data[$key] = $element; // Ne nettoyez pas les éléments qui ne sont pas des chaînes
            }
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

    public function getPostData(string $key = null): mixed
    {
        if ($key === null) {
            return $_POST;
        }
        return $this->data['post'][$key] ?? null;
    }

}