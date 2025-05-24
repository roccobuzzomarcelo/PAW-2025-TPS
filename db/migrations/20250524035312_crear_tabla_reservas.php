<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CrearTablaReservas extends AbstractMigration
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
    public function change()
    {
        $table = $this->table('reservas');

        $table->addColumn('usuario_id', 'integer', ['signed' => false])
              ->addColumn('libro_id', 'integer', ['signed' => false])
              ->addColumn('nombre', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 150])
              ->addColumn('calle', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('numero', 'integer', ['null' => true])
              ->addColumn('ciudad', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('provincia', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('codigo_postal', 'string', ['limit' => 10, 'null' => true])
              ->addColumn('metodo_entrega', 'enum', [
                    'values' => ['envío', 'retira'],
                    'default' => 'retira'
               ])
              ->addTimestamps() // crea created_at y updated_at
              ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->addForeignKey('libro_id', 'libros', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->create();
    }
}
