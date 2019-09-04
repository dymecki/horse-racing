<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Persistence\Connection\Db;

abstract class BaseDao
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = Db::instance()->connection();
    }

    public function db(): \PDO
    {
        return $this->db;
    }
}
