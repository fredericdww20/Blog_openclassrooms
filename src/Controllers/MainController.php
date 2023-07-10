<?php

namespace App\Controllers;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Affichage page principale +  controller mailswift
 */
class MainController extends Controller
{
	// Rendu vers la page principale
	public function index()
	{
		return $this->twig->render('main/index.html.twig');
	}

	public function swiftmailer()
	{
		// Vérification des données du formulaire
		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		$sujet = isset($_POST['sujet']) ? trim($_POST['sujet']) : '';
		$content = isset($_POST['message']) ? trim($_POST['message']) : '';

		// Validation des données du formulaire
		if (empty($name) || empty($lastname) || empty($email) || empty($sujet) || empty($content)) {
			// Les champs requis ne sont pas remplis, vous pouvez ajouter une gestion appropriée ici
			$message = 'Veuillez remplir tous les champs du formulaire.';
			return $this->twig->render('main/index.html.twig', [
				'message' => $message,
			]);
		}

		// Validation de l'adresse e-mail
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message = 'Adresse e-mail invalide.';
			return $this->twig->render('main/index.html.twig', [
				'message' => $message,
			]);
		}

		// Nettoyage des données pour éviter les attaques XSS
		$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
		$lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
		$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
		$sujet = htmlspecialchars($sujet, ENT_QUOTES, 'UTF-8');
		$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

		// Envoi du message
		$transport = (new Swift_SmtpTransport('mail.vedayshop.fr', 465, 'ssl'))
			->setUsername('blog@vedayshop.fr')
			->setPassword('Mypx7E5d#@z6&Qs5');

		$mailer = new Swift_Mailer($transport);

		$message = (new Swift_Message($sujet))
			->setFrom([$email => $name . ' ' . $lastname])
			->setTo(['blog@vedayshop.fr'])
			->setBody($content);

		$result = $mailer->send($message);

		$message = 'Message envoyé';

		return $this->twig->render('main/index.html.twig', [
			'message' => $message,
		]);
	}

}