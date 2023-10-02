<?php
/**
 *
 */

namespace App\Controllers;
use App\Models\AdminManager;
use App\Request;


class AdminController extends Controller
{
    /*
     * Affiche la liste des commentaires a valider sur la page d'administration
     */
    public function listcomment(): string
    {
        $request = new Request([]);

        $adminManager = new AdminManager();
        $comments = $adminManager->fetchcomment();
        $message = $request->getSessionData('message') ?? null;
        $output = $this->twig->render('admin/comment.html.twig', [
            'comments' => $comments,
            'message' => $message
        ]);
        unset($message);
        return $output;
    }

    /*
     * Affiche la liste des posts a valider sur la page d'administration
     */
    public function listvalidate(): string
    {
        $adminManager = new AdminManager();
        $posts = $adminManager->fetchAll();

        return $this->twig->render('admin/admin.html.twig', [
            'posts' => $posts]);
    }

    /*
     * Affiche la liste de post valider sur la page d'administration
     */
    public function list(): string
    {
        $request = new Request([]);

        $adminManager = new AdminManager();
        $posts = $adminManager->fetchvalidate();
        $message = $request->getSessionData('message') ?? null;
        $output = $this->twig->render('admin/posts.html.twig', [
            'posts' => $posts,
            'message' => $message
        ]);
        unset($message);
        return $output;
    }

    /*
     * Fonction de validation des posts depuis administration
     */
    public function update($id)
    {
        $adminManager = new AdminManager();
        $message = null;
        $errors = [];
        $sta = null;

        // Créez une instance de la classe Request pour gérer les données POST
        $request = new Request($_POST);

        if ($request->isPost()) {
            // Utilisez la méthode getPostData pour obtenir les données POST
            $sta = $request->get('sta');

            if (empty($sta)) {
                $errors[] = 'Le champ "sta" est requis.';
            }

            if (empty($errors)) {
                $adminManager->update($id, $sta);
                $this->addSuccess('Mise à jour réussie');
                $this->redirect('/OpenClassrooms/admin/posts');
            }
        }

        return $this->twig->render('admin/edit.html.twig', [
            'id' => $id,
            'sta' => $sta,
            'errors' => $errors,
        ]);
    }

    /*
     * Fonction de validation des commentaires depuis administration
     */
    public function updatecomments($id): string
    {
        $request = new Request($_POST);

        $adminManager = new AdminManager();
        $message = null;
        $errors = [];
        $sta = null;

        if ($request->isPost()) {
            $sta = $request->get('sta');

            if (empty($sta)) {
                $errors[] = 'Le champ "sta" est requis.';
            }

            if (empty($errors)) {
                try {
                    $adminManager->updatecomment($id, $sta);
                    $this->addSuccess('Mise à jour réussie');
                    $this->redirect('/OpenClassrooms/admin/comment');
                } catch (Exception $e) {
                    // Gérer l'exception ou envoie l'erreur
                    $errors[] = 'Une erreur s\'est produite lors de la mise à jour du commentaire.';
                }
            }
        }

        return $this->twig->render('admin/editcomment.html.twig', [
            'id' => $id,
            'sta' => $sta,
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}
