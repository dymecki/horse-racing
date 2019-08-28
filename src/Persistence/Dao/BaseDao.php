<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Persistence\Connection\Db;

abstract class BaseDao
{
    protected $db;

    public function __construct()
    {
        $this->db = Db::instance();
    }

    public function db(): Db
    {
        return $this->db;
    }

    public function name(): string
    {
        return \get_class($this);
    }

}
