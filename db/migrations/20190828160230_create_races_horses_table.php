<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

class CreateRacesHorsesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('races_horses', ['id' => false, 'primary_key' => ['race_id', 'horse_id']])
            ->addColumn('race_id', 'uuid')
            ->addColumn('horse_id', 'uuid')
            ->addColumn('distance_covered', 'decimal', ['default' => 0, 'precision' => 6, 'scale' => 2])
            ->addColumn('time', 'integer', ['default' => 0])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['race_id', 'horse_id'], ['unique' => true])
            ->addForeignKey('race_id', 'races', 'race_id')
            ->addForeignKey('horse_id', 'horses', 'horse_id')
            ->save();
    }
}
