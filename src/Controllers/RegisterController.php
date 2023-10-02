<?php

namespace App\Controllers;

use App\Models\UserManager;

class RegisterController extends Controller
{
    const ERROR_EMAIL_EXISTS = 'Cet email est déjà utilisé.';
    const ERROR_MISSING_FIELDS = 'Veuillez remplir tous les champs.';

    public function register()
    {
        $userManager = new UserManager();
        $errorMessage = null;
        $request = new \App\Request($_POST);

        if ($request->isPost()) {
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $email = $request->get('email');
            $password = $request->get('password');

            if ($this->validateForm($_POST)) {
                if (!$userManager->checkEmailExists($email)) {
                    $userManager->create($firstname, $lastname, $email, $password);
                    $this->addSuccess('Inscription réussie');
                    $this->redirect('/OpenClassrooms/');
                } else {
                    $errorMessage = self::ERROR_EMAIL_EXISTS;
                }
            } else {
                $errorMessage = self::ERROR_MISSING_FIELDS;
            }
        }

        return $this->twig->render('register/register.html.twig', ['errorMessage' => $errorMessage]);
    }

    private function validateForm($formData): bool
    {
        return $this->validateFields($formData);
    }

    private function validateFields($formData): bool
    {
        $fields = ['firstname', 'lastname', 'email', 'password'];
        foreach ($fields as $field) {
            if (empty($formData[$field])) {
                return false;
            }
        }
        return true;
    }
}