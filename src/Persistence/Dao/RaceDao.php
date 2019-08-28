<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\Race;

final class RaceDao extends BaseDao
{

    public function addRace(Race $race)
    {
        $this
            ->db()
            ->prepare('INSERT INTO races (distance) VALUES(?)')
            ->execute([$race->distance()]);
    }

    public function getAll()
    {
        $this->db()->execute('SELECT * FROM races');
    }
}
