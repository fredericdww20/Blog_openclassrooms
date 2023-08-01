<?php
/**
 *
 */

namespace App\Controllers;

use App\Models\UserManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConnectController extends Controller
{
    /**
     * @return string|void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \Exception
     */
    public function connect()
    {
        $userManager = new UserManager();
        $message = null;

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrfToken = $_SESSION['csrf_token'];

        $userManager = new UserManager();
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $csrfToken) {
                $message = 'Jeton CSRF non valide. Veuillez réessayer.';
            } else {
                $email = $_POST['email'];
                $password = $_POST['password'];
                try {
                    if ($userManager->checkEmailExists($email)) {
                        $user = $userManager->authentication($email, $password);
                        if ($user) {

                            $_SESSION['roles'] = $user->getRoles();

                            if ($_SESSION['roles'] === 'ROLE_ADMIN') {
                                $this->redirect('/OpenClassrooms/admin');
                            } else {
                                $this->redirect('/OpenClassrooms/');
                            }
                        } else {
                            $message = 'Identifiants de connexion incorrects';
                        }
                    } else {
                        $message = 'Utilisateur non trouvé';
                    }
                } catch (Exception $e) {
                    $message = 'Une erreur s\'est produite lors de l\'authentification';
                }
            }
        }

        return $this->twig->render('login/login.html.twig', ['message' => $message, 'csrfToken' => $csrfToken]);
    }


    public function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        header('Location: /OpenClassrooms/');
    }
}

