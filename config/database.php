<?php

namespace App\Config;

class Database
{
    private static $instance = null;
    private static $connection = null;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            self::$connection = new \PDO($dsn, $user, $password);

            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getConnection()
    {
        return self::$connection;
    }

    private function __clone() {}

    public function __wakeup() {}
}
