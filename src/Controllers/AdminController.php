<?php
/**
 *
 * PHP version 8.1
 */

namespace App\Controllers;

use App\Models\AdminManager;

/**
 * Class AdminController.
 * @version Release: 1.0
 */
class AdminController extends Controller
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['sta'])) {
                $sta = htmlspecialchars($_POST['sta'], ENT_QUOTES, 'UTF-8');
                if (empty($sta)) {
                    $errors[] = 'Le champ "sta" est requis.';
                }
                if (empty($errors)) {
                    $adminManager->update($id, $sta);
                    $_SESSION['message'] = 'Mise à jour réussie';
                    $this->redirect('/OpenClassrooms/admin/posts');
                }
            }
        }

        return $this->twig->render('admin/edit.html.twig', [
            'id' => $id,
            'sta' => $sta,
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    public function updatecomments($id)
    {
        $adminManager = new AdminManager();
        $message = null;
        $errors = [];
        $sta = null;

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['sta'])) {
                $sta = htmlspecialchars($_POST['sta'], ENT_QUOTES, 'UTF-8');
                if (empty($sta)) {
                    $errors[] = 'Le champ "sta" est requis.';
                }
                if (empty($errors)) {
                    try {
                        $adminManager->updatecomment($id, $sta);
                        $_SESSION['message'] = 'Mise à jour réussie';
                        header('Location: /OpenClassrooms/admin/comment');
                        return; // Renvoie un message de succès si la mise à jour à reussie
                    } catch (Exception $e) {
                        // Gérer l'exception ou envoie l'erreur
                        $errors[] = 'Une erreur s\'est produite lors de la mise à jour du commentaire.';
                    }
                }
            }
        }
        return $this->twig->render('admin/editco mment.html.twig', [
            'id' => $id,
            'sta' => $sta,
            'message' => $message,
            'errors' => $errors,
        ]);
    }

}