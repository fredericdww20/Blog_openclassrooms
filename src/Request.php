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

    private function validateForm($formData): bool
    {
        return $this->validateFields($formData);
    }

    private function validateFields($formData): bool
    {
        $fields = ['firstname', 'lastname', 'email', 'password'];
        foreach ($fields as $field) {
            if (empty($formData[$field])) {
                return false;
            }
        }
        return true;
    }
    public function checkEmailExists(string $email): bool
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $email,
        ]);
        $count = $statement->fetchColumn();
        return ($count > 0);
    }
}