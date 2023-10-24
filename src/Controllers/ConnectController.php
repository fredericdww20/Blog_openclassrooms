<?php

/**
 *
 */

namespace App\Controllers;

use App\Core\Request;
use App\Manager\UserManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConnectController extends AbstractController
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
                            $this->redirect('/admin');
                            // Arrêt de la fonction après la redirection
                        } else {
                            $this->addSuccess('Connexion réussie.');
                            $this->redirect('/');
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
        $request = new Request();
        $request->deleteSessionData('user_id'); // Supprimez les données de session spécifiques

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                1,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_unset();
        session_destroy();

        $this->redirect('/');
    }
}
