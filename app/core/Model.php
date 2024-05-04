<?php

namespace App\core;

use App\core\Database;

class Model extends Database
{
    private Database $database;
    protected string $table;
    
    private array $query = ['all' => 'SELECT * FROM'];

    public function __construct()
    {
        $this->database = Database::connect();
    }

    protected function where(array $where): Model
    {
        $holder = '';

        foreach (array_keys($where) as $key) {
            $holder .= "{$key} = :{$key} AND ";
        }

        $holder = trim($holder, ' AND ');

        $this->query['where'] = " WHERE {$holder}";
        $this->query['param'] = $where;

        return $this;
    }

    protected function all(): bool|object
    {
        return $this->database->query("{$this->query['all']} {$this->table}");
    }

    protected function get(): bool|object
    {
        return $this->database->query(
            "{$this->query['all']} {$this->table}{$this->query['where']}",
            $this->query['param']
        );
    }

    protected function first(): bool|object
    {
        return $this->database->query(
            "{$this->query['all']} {$this->table}{$this->query['where']}",
            $this->query['param']
        )[0];
    }

    protected function firstWhere(array $where): bool|object
    {
        $this->where($where);

        return $this->database->query(
            "{$this->query['all']} {$this->table}{$this->query['where']}",
            $this->query['param']
        )[0];
    }

    protected function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $holder = '';

        foreach (array_keys($data) as $key) {
            $holder .= ":{$key}, ";
        }

        $holder = trim($holder, ', ');

        return $this->database->query("INSERT INTO {$this->table} ($columns) VALUES ($holder)", $data);
    }

    protected function update(array $data): bool
    {
        $holder = '';

        foreach (array_keys($data) as $key) {
            $holder .= "{$key} = :{$key}, ";
        }

        $holder = trim($holder, ', ');

        return $this->database->query(
            "UPDATE {$this->table} SET {$holder}{$this->query['where']}",
            array_merge($data, $this->query['param'])
        );
    }

    protected function delete(): bool
    {
        return $this->database->query(
            "DELETE FROM {$this->table}{$this->query['where']}",
            $this->query['param']
        );
    }

    protected function custom(string $query, array $data): bool
    {
        return $this->database->query($query, $data);
    }

    protected function string_to_array(string $value): array
    {
        $pattern = '/[\,\s]/';
        return preg_split($pattern, $value, -1, PREG_SPLIT_NO_EMPTY);
    }

    protected function array_to_string(array $array): string
    {
        return implode(',', $array);
    }
}
