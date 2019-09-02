<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class CreateHorsesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('horses', ['id' => false, 'primary_key' => ['horse_id']]);
        $table
            ->addColumn('horse_id', 'uuid', ['default' => Literal::from('uuid_generate_v4()')])
            ->addColumn('speed', 'decimal', ['precision' => 3, 'scale' => 1])
            ->addColumn('strength', 'decimal', ['precision' => 3, 'scale' => 1])
            ->addColumn('endurance', 'decimal', ['precision' => 3, 'scale' => 1])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->create();
    }
}
