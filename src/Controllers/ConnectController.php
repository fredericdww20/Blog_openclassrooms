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
    public function connect(): string
    {
        $request = new Request($_POST);

        $userManager = new UserManager();

        if (!$request->getSessionData('csrf_token')) {
            $request->setSessionData('csrf_token', bin2hex(random_bytes(32)));
        }
        $csrfToken = $request->getSessionData('csrf_token');

        if ($request->isPost()) {
            $postedCsrfToken = $request->get('csrf_token');
            if (empty($postedCsrfToken) || $postedCsrfToken !== $csrfToken) {
                $this->addError('Jeton CSRF non valide. Veuillez réessayer.');
            } else {
                $email = $request->get('email');
                $password = $request->get('password');

                if ($userManager->checkEmailExists($email)) {
                    $user = $userManager->authentication($email, $password);
                    if ($user) {
                        $request->setSessionData('roles', $user->getRoles());

                        if ($request->getSessionData('roles') === 'ROLE_ADMIN') {
                            $this->addSuccess('Connexion en tant qu\'administrateur réussie.');
                            $this->redirect('/OpenClassrooms/admin');
                            // Arrêt de la fonction après la redirection
                        } else {
                            $this->addSuccess('Connexion réussie.');
                            $this->redirect('/OpenClassrooms/');
                            // Arrêt de la fonction après la redirection
                        }
                        return '';
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

