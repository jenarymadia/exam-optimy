<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private PDO $pdo;

    public function __construct(private string $dsn, private string $user, private string $password)
    {
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    public function select(string $sql): array
    {
        $sth = $this->pdo->query($sql);
        return $sth->fetchAll();
    }

    public function exec(string $sql): int|false
    {
        return $this->pdo->exec($sql);
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}