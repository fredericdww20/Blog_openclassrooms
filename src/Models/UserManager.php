<?php

namespace App\Models;


use PDO;

class UserManager
{
    private PDO $pdo;

    // Connexion à la base de données
    public function __construct() {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', 'pofr8259_blogopen', 'aW3GTb^~r@WA', $options);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
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
        $sql = 'SELECT id, email, password, firstname, lastname, roles FROM user WHERE email = :email';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $email,
        ]);

        $user = $statement->fetchObject(User::class);
        if ($user && password_verify($password, $user->getPassword())) {

            $_SESSION['LOGGED_USER'] = $email;
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['lastname'] = $user->getLastname();
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['roles'] = $user->getRoles();
            $_SESSION['user_id'] = $user->getId();
            return $user;
        }
        return null;
    }

    // On récupére les informations de l'utilisateur
    public function fetchuser()
    {
        $sql = 'SELECT user.*, COUNT(DISTINCT post.id) AS post_count, COUNT(comment.id) AS comment_count
            FROM user
            LEFT JOIN post ON user.id = post.id_user
            LEFT JOIN comment ON user.id = comment.id_user
            WHERE user.id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

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