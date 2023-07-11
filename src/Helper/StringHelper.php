<?php

namespace App\Helper;

class StringHelper
{
    public static function cleanString(string $string, bool $deleteHtml = false): string {

        $string = htmlentities(trim($string));

        return $deleteHtml ? htmlspecialchars($string) : $string;
    }

    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}