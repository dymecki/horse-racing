<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateHorsesTable extends AbstractMigration
{
    public function change()
    {
        $ddl = 'CREATE TABLE horses (
            horse_id    uuid        not null PRIMARY KEY,
            speed       horse_stat  not null,
            strength    horse_stat  not null,
            endurance   horse_stat  not null,
            created_at  timestamptz DEFAULT CURRENT_TIMESTAMP,
            updated_at  timestamptz
        );';

        $this->execute($ddl);
    }
}
