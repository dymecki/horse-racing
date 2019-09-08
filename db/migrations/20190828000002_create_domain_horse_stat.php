<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateDomainHorseStat extends AbstractMigration
{

    public function change()
    {
        $ddl = 'CREATE DOMAIN horse_stat AS 
                    NUMERIC(3,1)
                    NOT NULL
                    CHECK (value >= 0 AND value <= 10);
                ';

        $this->execute($ddl);
    }
}
