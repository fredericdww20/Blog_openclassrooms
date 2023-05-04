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
		$this->twig = new Environment($loader, [
			'debug' => true,
		]);
		$this->twig->addExtension(new \Twig\Extension\DebugExtension());
		$this->twig->addGlobal('session', $_SESSION);


	}
}