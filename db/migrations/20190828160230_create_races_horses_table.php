<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateRacesHorsesTable extends AbstractMigration
{
    public function change()
    {
        $ddl = 'CREATE TABLE races_horses (
                    race_id             uuid            not null,
                    horse_id            uuid            not null,
                    distance_covered    numeric(6,2)    not null default 0,
                    time                numeric(6,2)    not null default 0,
                    created_at          timestamptz     default CURRENT_TIMESTAMP,
                    updated_at          timestamptz,

                    FOREIGN KEY (race_id) REFERENCES races (race_id),
                    FOREIGN KEY (horse_id) REFERENCES horses (horse_id)
            );';

        $ddl .= 'CREATE UNIQUE INDEX ON races_horses (race_id, horse_id);';
        $ddl .= 'CREATE INDEX ON races_horses (distance_covered);';

        $this->execute($ddl);
    }
}
