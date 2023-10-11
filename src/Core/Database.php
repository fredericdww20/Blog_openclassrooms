<?php

namespace App\Core;
use PDO;
use PDOException;
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
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
            $logger = new Logger('error_logger');
            $logger->pushHandler(new StreamHandler('path/to/log/file.log', Logger::ERROR));
            $logger->error($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
