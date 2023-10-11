<?php

namespace App\Core;

use App\Helper\StringHelper;

class Request
{
    /*
     * Nettoie chaque élément de ce tableau
     */
    public function __construct(private readonly array $data = [])
    {
        foreach ($data as $key => $element) {
            if (is_string($element)) {
                $data[$key] = StringHelper::cleanString($element, true);
            } else {
                $data[$key] = $element; // Ne nettoyez pas les éléments qui ne sont pas des chaînes
            }
        }

    }

    /*
     * Permet de récupérer une valeur du tableau $data en utilisant une clé. Si la clé n'existe pas, elle renvoie null.
     */
    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    /*
     * Vérifie si la méthode de la requête courante est POST
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /*
     * Stocke une valeur dans la session PHP avec une clé donnée.
     */
    public function setSessionData($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /*
     * Récupère une valeur de la session PHP en utilisant une clé. Si la clé n'existe pas, elle renvoie null
     */
    public function getSessionData($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /*
     * Permet de récupérer des données POST. Si une clé est fournie, elle renvoie la valeur associée à cette clé. Sinon, elle renvoie tout le tableau $_POST
     */
    public function getPostData(string $key = null): mixed
    {
        if ($key === null) {
            return $_POST;
        }
        return $this->data['post'][$key] ?? null;
    }

    /*
     * Supprime une valeur de la session PHP en utilisant une clé donnée.
     */
    public function deleteSessionData($key): void
    {
        unset($_SESSION[$key]);
    }
}