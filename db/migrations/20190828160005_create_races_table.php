<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateRacesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('races', ['id' => false, 'primary_key' => ['race_id']])
            ->addColumn('race_id', 'uuid')
            ->addColumn('distance', 'decimal', ['default' => 0, 'precision' => 6, 'scale' => 2])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->create();
    }
}
