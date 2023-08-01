<?php

namespace App\Controllers;

use App\Models\UserManager;

class UserController extends Controller
{
    public function infouser()
    {

        $loggedInUserId = $_SESSION['user_id'];

        $userManager = new Usermanager();
        $user = $userManager->fetchuser($loggedInUserId);

        return $this->twig->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

}