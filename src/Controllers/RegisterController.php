<?php

namespace App\Controllers;

use App\Helper\StringHelper;
use App\Models\UserManager;
use App\Request;

class RegisterController extends Controller
{
    const ERROR_EMAIL_EXISTS = 'Cet email est déjà utilisé.';
    const ERROR_MISSING_FIELDS = 'Veuillez remplir tous les champs.';

    public function register()
    {
        $userManager = new UserManager();
        $errorMessage = null;

        $request = new Request($_POST);

        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $password = $request->get('password');

        if (!$firstname || !$lastname || !$email || $password || !StringHelper::isValidEmail($email) || !StringHelper::isValidEmail($email) ) {

            $userManager->create($firstname, $lastname, $email, $password);
            $message = 'Message';
            return $this->twig->render('main/index.html.twig', [
                'message' => $message,
            ]);
        }
    }




}