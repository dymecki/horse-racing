<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class CreateHorsesTable extends AbstractMigration
{
    public function change()
    {
//        $table = $this->table('horses', ['id' => false, 'primary_key' => ['horse_id']]);
//        $table
//            ->addColumn('horse_id', 'uuid', ['default' => Literal::from('uuid_generate_v4()')])
////            ->addColumn('speed', 'decimal', ['precision' => 3, 'scale' => 1])
////            ->addColumn('strength', 'decimal', ['precision' => 3, 'scale' => 1])
////            ->addColumn('endurance', 'decimal', ['precision' => 3, 'scale' => 1])
//            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
//            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
//            ->create();

        $ddl = 'CREATE TABLE horses (
            horse_id    uuid not null,
            speed       horse_stat not null,
            strength    horse_stat not null,
            endurance   horse_stat not null,
            created_at  timestamptz DEFAULT CURRENT_TIMESTAMP,
            updated_at  timestamptz,

            PRIMARY KEY (horse_id)
        );';

        $this->execute($ddl);
    }
}
