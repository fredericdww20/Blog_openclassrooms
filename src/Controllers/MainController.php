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


    private string $addSuccess;

    public function index()
    {
        return $this->twig->render('main/index.html.twig');
    }

    public function swiftmailer()
    {
        $request = new Request([
            'post' => $_POST,
        ]);

        $name = $request->getPostData('name');
        $lastname = $request->getPostData('lastname');
        $email = $request->getPostData('email');
        $sujet = $request->getPostData('sujet');
        $content = $request->getPostData('message');

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