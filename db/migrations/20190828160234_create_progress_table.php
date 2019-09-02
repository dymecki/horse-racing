<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
//use Phinx\Util\Literal;

class CreateProgressTable extends AbstractMigration
{
    public function change()
    {
//        $this->table('progress', ['id' => false])
//            ->addColumn('race_id', 'uuid')
//            ->addColumn('horse_id', 'uuid')
//            ->addColumn('distance_covered', 'decimal', ['default' => 0, 'precision' => 6, 'scale' => 2])
//            ->addColumn('time', 'integer', ['default' => 0])
//            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
//            ->addColumn('updated_at', 'timestamp', ['null' => true])
//            ->addIndex(['race_id'])
//            ->addIndex(['horse_id'])
//            ->addIndex(['race_id', 'horse_id'], ['unique' => true])
//            ->addForeignKey('race_id', 'races', 'race_id')
//            ->addForeignKey('horse_id', 'horses', 'horse_id')
//            ->create();
    }
}
