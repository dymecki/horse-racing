<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateRacesTable extends AbstractMigration
{
    public function change()
    {
        $ddl = 'CREATE TABLE races (
                    race_id     uuid            not null PRIMARY KEY ,
                    distance    numeric(6,2)    not null default 0,
                    created_at  timestamptz     default  CURRENT_TIMESTAMP,
                    updated_at  timestamptz
                )';

        $this->execute($ddl);
    }
}
