<?php

declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class CreateRacesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('races', ['id' => false, 'primary_key' => ['race_id']])
            ->addColumn('race_id', 'uuid', ['default' => Literal::from('uuid_generate_v4()')])
            ->addColumn('distance', 'integer')
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->create();
    }
}
