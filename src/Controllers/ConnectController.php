<?php
/**
 *
 */

namespace App\Controllers;

use App\Models\UserManager;
use App\Request;
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
        $request = new Request([
            'post' => $_POST,
            'session' => $_SESSION,
        ]);

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrfToken = $_SESSION['csrf_token'];

        if ($request->isPost()) {
            $postedCsrfToken = $request->getPostData('csrf_token');
            if (empty($postedCsrfToken) || $postedCsrfToken !== $csrfToken) {
                $this->addError('Jeton CSRF non valide. Veuillez réessayer.');
            } else {
                $email = $request->getPostData('email');
                $password = $request->getPostData('password');

                if ($userManager->checkEmailExists($email)) {
                    $user = $userManager->authentication($email, $password);
                    if ($user) {
                        $_SESSION['roles'] = $user->getRoles();

                        if ($_SESSION['roles'] === 'ROLE_ADMIN') {
                            $this->addSuccess('Connexion en tant qu\'administrateur réussie.');
                            $this->redirect('/OpenClassrooms/admin');
                            return;  // Arrêt de la fonction après la redirection
                        } else {
                            $this->addSuccess('Connexion réussie.');
                            $this->redirect('/OpenClassrooms/');
                            return;  // Arrêt de la fonction après la redirection
                        }
                    } else {
                        $this->addError('Identifiants de connexion incorrects');
                    }
                } else {
                    $this->addError('Utilisateur non trouvé');
                }
            }
        }
        return $this->twig->render('login/login.html.twig', ['csrfToken' => $csrfToken]);
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

