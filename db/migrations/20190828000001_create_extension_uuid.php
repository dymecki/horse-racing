<?php

use Phinx\Migration\AbstractMigration;

class CreateExtensionUuid extends AbstractMigration
{
    public function change()
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
    }

}
