<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\RunningHorse;

final class HorseDao extends BaseDao
{

    public function addHorse(RunningHorse $horse)
    {
        $this
            ->db()
            ->prepare('INSERT INTO horses (name) VALUES(?)')
            ->execute([$horse->horse()->name()]);
    }

    public function getHorse()
    {
        
    }
}
