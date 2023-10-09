<?php

namespace App\Controllers;

use App\Helper\StringHelper;
use App\Request;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Affichage page principale + controller mailswift
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
        $request = new Request($_POST);
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $sujet = $request->get('sujet');
        $content = $request->get('message');

        // Validation des données du formulaire
        if (!$name || !$lastname || !$email || !$sujet || !$content || !StringHelper::isValidEmail($email)) {
            // Les champs requis ne sont pas remplis
            $this->addError('Veuillez remplir tous les champs du formulaire.');
            return $this->twig->render('main/index.html.twig');
        }

        // Envoi du message
        $transport = (new Swift_SmtpTransport('mail.vedayshop.fr', 465, 'ssl'))
            ->setUsername('blog@vedayshop.fr')
            ->setPassword('Mypx7E5d#@z6&Qs5');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message($sujet))
            ->setFrom([$email => $name . ' ' . $lastname])
            ->setTo(['blog@vedayshop.fr'])
            ->setBody($content);

        $mailer->send($message);

        $this->addSuccess('Message envoyé');

        $this->redirect('/OpenClassrooms/');
    }

}