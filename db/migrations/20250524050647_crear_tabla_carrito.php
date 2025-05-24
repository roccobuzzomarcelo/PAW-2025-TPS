<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CrearTablaCarrito extends AbstractMigration
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
        $table = $this->table('carrito_items');
        
        $table
            ->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('libro_id', 'integer', ['signed' => false])
            ->addColumn('cantidad', 'integer', ['default' => 1])
            ->addColumn('agregado_en', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey('libro_id', 'libros', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
