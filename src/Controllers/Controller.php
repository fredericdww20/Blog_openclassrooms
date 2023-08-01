<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected Environment $twig;

    private array $messages = [];

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');

        $this->twig = new Environment($loader, ['debug' => true]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);

        if(isset($_SESSION['message']) && is_array($_SESSION['message'])) {
            $this->messages = $_SESSION['message'];
            $this->twig->addGlobal('messages', $this->messages);

            unset($_SESSION['message']);
        }
    }

    public function addSuccess(string $message): void
    {
        $this->messages['success'] = $message;
    }

    public function addError(string $message): void
    {
        $this->messages['error'] = $message;
    }

    public function redirect(string $path): void {
        if($this->messages) {
            $_SESSION['message'] = $this->messages;
        }

        header('Location: ' . $path);
    }
}