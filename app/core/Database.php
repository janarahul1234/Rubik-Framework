<?php

namespace App\core;

use PDO;

class Database
{
    private static $instance = null;
    private \PDO $pdo;

    private function __construct()
    {
        $db_host = $_ENV['DATABASE_HOST'];
        $db_name = $_ENV['DATABASE_NAME'];
        $db_user = $_ENV['DATABASE_USER'];
        $db_password = $_ENV['DATABASE_PASSWORD'];

        $url = "mysql:host={$db_host};dbname={$db_name}";

        try {
            $this->pdo = new \PDO($url, $db_user, $db_password);
        } catch (\PDOException $e) {
            exit('Databace error: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public static function connect(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function allQuery(string $query, array $values = []): bool
    {
        $conn = $this->pdo;
        $values = $this->convert($values);

        try {
            $stmt = $conn->prepare($query);
            return $stmt->execute($values);
        } catch (\PDOException $e) {
            exit('Query error: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public function selectQuery(string $query, array $values = []): bool|object
    {
        $conn = $this->pdo;
        $values = $this->convert($values);

        try {
            $stmt = $conn->prepare($query);
            $stmt->execute($values);

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            exit('Query error: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public function customQuery(string $query, array $values = []): bool|object
    {
        return $this->selectQuery($query, $values);
    }

    private function convert(array $values = []): array
    {
        $temp = [];
        foreach ($values as $key => $value) {
            $temp[":{$key}"] = $value;
        }
        return $temp;
    }
}
