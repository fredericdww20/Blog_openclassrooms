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
     */
    public function connect()
    {
        $userManager = new UserManager();
        $message = null;
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            try {
                if ($userManager->checkEmailExists($email)) {
                    $user = $userManager->authentication($email, $password);
                    if ($user) {
                        // Assign the user's role to the session
                        $_SESSION['roles'] = $user->getRoles();

                        // Check the user's role for redirection
                        if ($_SESSION['roles'] === 'ROLE_ADMIN') {
                            header('Location: /OpenClassrooms/admin');
                            exit;
                        } else {
                            header('Location: /OpenClassrooms/');
                            exit;
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
        return $this->twig->render('login/login.html.twig', [
            'message' => $message]);
    }

    /**
     * @return void
     */
    public function logout()
    {
        session_start();
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
        exit;
    }
}

