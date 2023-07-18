<?php

namespace App\Controllers;

use App\Models\UserManager;

class UserController extends Controller
{
    public function infouser()
    {
        $userManager = new Usermanager();
        $user = $userManager->fetchuser();
        return $this->twig->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

    public function add(): string
    {

        $message = null;

        if (!empty ($_POST)) {

            $image =  htmlentities($_POST['image']);

            $userManager = new UserManager();

            // Appel de la méthode addImage du UserManager
            $userManager->addImage($_POST['image']);

            // Afficher un message de succès ou effectuer d'autres opérations après l'ajout de l'image

            $message = "L'image a été ajoutée avec succès.";
        }

        // Rendu du template avec le message (ou d'autres données) si nécessaire
        return $this->twig->render('profil/profil.html.twig', ['message' => $message]);
    }

}