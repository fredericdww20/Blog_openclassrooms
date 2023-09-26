<?php
/**
 *
 */

namespace App\Controllers;
use App\Models\AdminManager;
use App\Request;


class AdminController extends Controller
{
    public function listcomment(): string
    {
        $adminManager = new AdminManager();
        $comments = $adminManager->fetchcomment();
        $message = $_SESSION['message'] ?? null;
        $output = $this->twig->render('admin/comment.html.twig', [
            'comments' => $comments,
            'message' => $message
        ]);
        unset($_SESSION['message']);
        return $output;
    }

    public function listvalidate(): string
    {
        $adminManager = new AdminManager();
        $posts = $adminManager->fetchAll();

        return $this->twig->render('admin/admin.html.twig', [
            'posts' => $posts]);
    }

    public function list(): string
    {
        $adminManager = new AdminManager();
        $posts = $adminManager->fetchvalidate();
        $message = $_SESSION['message'] ?? null;
        $output = $this->twig->render('admin/posts.html.twig', [
            'posts' => $posts,
            'message' => $message
        ]);
        unset($_SESSION['message']);
        return $output;
    }

    public function update($id)
    {
        $adminManager = new AdminManager();
        $message = null;
        $errors = [];
        $sta = null;

        // Créez une instance de la classe Request pour gérer les données POST
        $request = new Request([
            'post' => $_POST,
        ]);

        if ($request->isPost()) {
            // Utilisez la méthode getPostData pour obtenir les données POST
            $sta = $request->getPostData('sta');

            if (empty($sta)) {
                $errors[] = 'Le champ "sta" est requis.';
            }

            if (empty($errors)) {
                $adminManager->update($id, $sta);
                $_SESSION['message'] = 'Mise à jour réussie'; // Utilisation de $_SESSION
                $this->redirect('/OpenClassrooms/admin/posts');
                return; // Arrêtez la fonction après la redirection
            }
        }

        return $this->twig->render('admin/edit.html.twig', [
            'id' => $id,
            'sta' => $sta,
            'message' => isset($_SESSION['message']) ? $_SESSION['message'] : null,
            'errors' => $errors,
        ]);
    }


    public function updatecomments($id)
    {
        $adminManager = new AdminManager();
        $message = null;
        $errors = [];
        $sta = null;

        // Créez une instance de la classe Request
        $request = new Request([
            'post' => $_POST,
            // Autres données, si nécessaire
        ]);

        if ($request->isPost()) {
            // Utilisez la méthode getPostData pour obtenir les données POST
            $sta = $request->getPostData('sta');

            if (empty($sta)) {
                $errors[] = 'Le champ "sta" est requis.';
            }

            if (empty($errors)) {
                try {
                    $adminManager->updatecomment($id, $sta);
                    $_SESSION['message'] = 'Mise à jour réussie';
                    header('Location: /OpenClassrooms/admin/comment');
                    return; // Renvoie un message de succès si la mise à jour a réussi
                } catch (Exception $e) {
                    // Gérer l'exception ou envoyer l'erreur
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