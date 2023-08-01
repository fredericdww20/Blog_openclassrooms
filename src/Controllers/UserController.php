<?php

namespace App\Controllers;

use App\Models\UserManager;

class UserController extends Controller
{
    public function infouser()
    {

        $loggedInUserId = $_SESSION['user_id']; // Remplacez 'user_id' par la clé utilisée pour stocker l'ID de l'utilisateur connecté.

        // Maintenant, utilisez $loggedInUserId pour récupérer les informations de l'utilisateur connecté.
        // Ici, nous supposons que la méthode fetchUserById() de la classe Usermanager récupère l'utilisateur par son ID.
        $userManager = new Usermanager();
        $user = $userManager->fetchuser($loggedInUserId);

        return $this->twig->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

}