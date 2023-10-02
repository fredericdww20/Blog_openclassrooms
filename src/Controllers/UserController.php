<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Request;

class UserController extends Controller
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