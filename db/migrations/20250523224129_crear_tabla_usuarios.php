<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CrearTablaUsuarios extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $tabla = $this->table('usuarios');
        $tabla
            ->addColumn('nombre', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('rol', 'enum', ['values' => ['usuario', 'admin'], 'default' => 'usuario'])
            ->addColumn('fecha_creacion', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('activo', 'boolean', ['default' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
