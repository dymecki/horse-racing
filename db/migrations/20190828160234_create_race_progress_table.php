<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class CreateRaceProgressTable extends AbstractMigration
{

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('horses_progress', ['id' => false])
//        $this->table('horses_progress', ['id' => false, 'primary_key' => ['id']])
//            ->addColumn('id', 'uuid', ['default' => Literal::from('uuid_generate_v4()')])
            ->addColumn('race_horse_id', 'uuid')
            ->addColumn('distance_covered', 'integer', ['default' => 0])
            ->addColumn('time', 'integer', ['default' => 0])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->addIndex(['race_horse_id'])
            ->addForeignKey('race_horse_id', 'races_horses', 'race_horse_id')
            ->create();
    }
}
