<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
//use Phinx\Util\Literal;

class CreateFinishedRacesView extends AbstractMigration
{
    public function change()
    {
        $sql = 'CREATE VIEW finished_races_view AS
                SELECT r.race_id,
                       r.distance,
                       r.created_at,
                       h.horse_id,
                       h.speed,
                       h.strength,
                       h.endurance,
                       rh.distance_covered,
                       rh."time"
                  FROM horses h
                  JOIN races_horses rh USING(horse_id)
                  JOIN races r         USING(race_id)
                 WHERE rh.distance_covered = r.distance;';

        $this->execute($sql);
    }
}
