<?php

declare(strict_types=1);

namespace App\Persistence;

use \PDO;

final class Db
{
    private static $instance;
    private        $connection;

    private function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => true
        ];

        try {
            $this->connection = new PDO(
                $this->dsn(),
                getenv('DB_USER'),
                getenv('DB_PASS'),
                $options
            );
        } catch (\PDOException $e) {
            // Rethrow exception to prevent db credentials being shown on the page
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function connection(): PDO
    {
        return $this->connection;
    }

    private function dsn(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s',
            getenv('DB_DRIVER'),
            getenv('DB_HOST'),
            getenv('DB_NAME')
        );
    }

    public function __clone()
    {
        throw new \Exception('Singleton cloning forbidden');
    }
}
