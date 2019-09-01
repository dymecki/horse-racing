<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class CreateRacesHorsesTable extends AbstractMigration
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
        $this->table('races_horses', ['id' => false])
//            ->addColumn('race_horse_id', 'uuid', ['default' => Literal::from('uuid_generate_v4()')])
            ->addColumn('race_id', 'uuid')
            ->addColumn('horse_id', 'uuid')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->addIndex(['race_id'])
            ->addIndex(['horse_id'])
            ->addIndex(['race_id', 'horse_id'], ['unique' => true])
            ->addForeignKey('race_id', 'races', 'race_id')
            ->addForeignKey('horse_id', 'horses', 'horse_id')
            ->save();
    }
}
