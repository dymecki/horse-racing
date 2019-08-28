<?php

declare(strict_types=1);

namespace App\Persistence\Connection;

use \PDO;
use PDOStatement;

final class Db
{
    /** @var Db */
    private static $instance;
    private        $db;

    private function __construct(DbCredentials $credentials)
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => true
        ];

        try {
            $this->db = new PDO(
                $credentials->dsn(),
                $credentials->user(),
                $credentials->password(),
                $options
            );
        }
        catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function instance(): self
    {
        if ( ! self::$instance) {
            self::$instance = new self(
                DbCredentialsFactory::build()
            );
        }

        return self::$instance;
    }

    // a proxy to native PDO methods
    public function __call($method, $args)
    {
        return \call_user_func_array([$this->db, $method], $args);
    }

    // a helper function to run prepared statements smoothly
    public function run(string $sql, array $args = []): PDOStatement
    {
        if ( ! $args) {
            return $this->db->query($sql);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);

        return $stmt;
    }

//    public function prepare(string $sql): DbStmt
//    {
//        return new DbStmt($this->db->prepare($sql));
//    }

    public function getLastQuery(): string
    {
        return $this->db()->lastInsertId();
    }

    public function db(): PDO
    {
        return $this->db;
    }

}
