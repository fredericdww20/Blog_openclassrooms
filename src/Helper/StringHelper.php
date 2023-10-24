<?php

namespace App\Helper;

class StringHelper
{
    /*
     * Nettoyage de la chaine
     */
    public static function cleanString(string $string, bool $deleteHtml = false): string
    {

        $string = htmlentities(trim($string));

        return $deleteHtml ? htmlspecialchars($string) : $string;
    }

    /*
     * Verifie si l'email est valide
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
