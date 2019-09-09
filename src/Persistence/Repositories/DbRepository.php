<?php

declare(strict_types = 1);

namespace App\Persistence\Repositories;

use App\Persistence\Db;

abstract class DbRepository
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = Db::instance()->connection();
    }
}
