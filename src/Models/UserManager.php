<?php

namespace App\Models;

use App\Request;
use PDO;
use PDOException;

class UserManager
{
    private PDO $pdo;

    // Connexion à la base de données
    public function __construct()
    {
        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $pdoOptions);
        } catch (PDOException $e) {
            // Lancer une exception personnalisée au lieu d'utiliser echo
            throw new DatabaseConnectionException('Connection error: ' . $e->getMessage());
        }
    }

    // Fonction enregistrement utilisateur en base de données
    public function create(string $lastname, string $firstname, string $email, string $password)
    {
        $sql = 'INSERT INTO user (lastname, firstname, email, password, roles) VALUES (:lastname, :firstname, :email, :password, :roles)';

        $statement = $this->pdo->prepare($sql);

        $roles = 'ROLE_USER';

        $statement->execute([
            'lastname' => $lastname,
            'firstname' => $firstname,
            'email' => $email,
            'roles' => $roles,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

    // Vérifie les information de l'utilisateur au moment de la connexion
    public function authentication(string $email, string $password)
    {
        $request = new Request($_POST);

        $sql = 'SELECT id, email, password, firstname, lastname, roles FROM user WHERE email = :email';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $email,
        ]);

        $user = $statement->fetchObject(User::class);
        if ($user && password_verify($password, $user->getPassword())) {

            $request->setSessionData('email', $user->getEmail());
            $request->setSessionData('lastname', $user->getLastname());
            $request->setSessionData('firstname', $user->getFirstname());
            $request->setSessionData('roles', $user->getRoles());
            $request->setSessionData('user_id', $user->getId());
            $request->setSessionData('LOGGED_USER', $email);
            return $user;
        }
        return null;
    }

    // On récupére les informations de l'utilisateur
    public function fetchuser()
    {
        $request = new Request($_POST);

        $loggedInUserId = $request->getSessionData('user_id');

        $sql = 'SELECT user.*, COUNT(DISTINCT post.id) AS post_count, COUNT(comment.id) AS comment_count
            FROM user
            LEFT JOIN post ON user.id = post.id_user
            LEFT JOIN comment ON user.id = comment.id_user
            WHERE user.id = :user_id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $loggedInUserId]);

        return $statement->fetchObject(Post::class);
    }

    // Vérification de l'existance de l'email en base de données
    private function validateForm($formData): bool
    {
        return $this->validateFields($formData);
    }

    private function validateFields($formData): bool
    {
        $fields = ['firstname', 'lastname', 'email', 'password'];
        foreach ($fields as $field) {
            if (empty($formData[$field])) {
                return false;
            }
        }
        return true;
    }
    public function checkEmailExists(string $email): bool
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $email,
        ]);
        $count = $statement->fetchColumn();
        return ($count > 0);
    }
}