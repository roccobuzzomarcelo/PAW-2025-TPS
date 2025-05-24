<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class EliminarTablaUsuarios extends AbstractMigration
{
    
    public function change(): void
    {
        $this->table('reservas')->drop()->save();
        $this->table('usuarios')->drop()->save();
    }
}
