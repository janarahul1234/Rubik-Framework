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

    public function query(string $query, array $values = []): bool|object
    {
        $conn = $this->pdo;
        $values = $this->convert($values);

        try {
            $stmt = $conn->prepare($query);
            $exec_result = $stmt->execute($values);
        } catch (\PDOException $e) {
            exit('Query error: ' . $e->getMessage() . PHP_EOL);
        }

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return count($result) > 0 ? $result : $exec_result;
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