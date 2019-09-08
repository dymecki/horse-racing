<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateActiveRacesView extends AbstractMigration
{
    public function change()
    {
        $sql = 'CREATE VIEW active_races_view AS
                SELECT r.race_id
                  FROM races r
                  JOIN races_horses rh USING(race_id)
                 WHERE rh.distance_covered < r.distance
                 GROUP BY r.race_id
                 ORDER BY r.created_at DESC';

        $this->execute($sql);
    }
}
