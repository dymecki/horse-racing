<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class AddRacesCheckDistanceConstraint extends AbstractMigration
{
    public function change()
    {
        $this->execute('ALTER TABLE races ADD CONSTRAINT check_distance CHECK (distance > 0)');
    }
}
