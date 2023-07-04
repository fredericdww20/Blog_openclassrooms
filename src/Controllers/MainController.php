<?php

namespace App\Controllers;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class MainController extends Controller
{
	// Rendu vers la page principale
	public function index()
	{
		return $this->twig->render('main/index.html.twig');
	}

	public function swiftmailer(): void
	{
		$transport = (new Swift_SmtpTransport('mail.vedayshop.fr', 465))
			->setUsername('blog@vedayshop.fr')
			->setPassword('Mypx7E5d#@z6&Qs5');

		$mailer = new Swift_Mailer($transport);

		$name = $_POST['name'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$sujet = $_POST['sujet'];
		$content = $_POST['message'];

		$message = (new Swift_Message($sujet))
			->setFrom([$email => $name . ' ' . $lastname])
			->setTo(['blog@vedayshop.fr'])
			->setBody($content);

		$result = $mailer->send($message);
	}

}