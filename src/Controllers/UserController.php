<?php

namespace App\Controllers;

use App\Core\Request;
use App\Manager\UserManager;

class UserController extends AbstractController
{
    public function infouser()
    {
        $request = new Request($_POST);

        $loggedInUserId = $request->get('user_id');

        $userManager = new Usermanager();
        $user = $userManager->fetchuser($loggedInUserId);

        return $this->twig->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }
}
