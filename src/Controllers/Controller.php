<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
	protected Environment $twig;

	public function __construct()
	{
		$loader = new FilesystemLoader(__DIR__ . '/../../templates');
		$this->twig = new Environment($loader);
		$this->twig->addGlobal('session', $_SESSION);
	}
}