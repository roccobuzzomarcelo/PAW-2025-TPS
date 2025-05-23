<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PrimerasTablas extends AbstractMigration
{
    public function change(): void
    {
        $tablaLibros = $this->table('libros');
        $tablaLibros->addColumn('titulo', 'string', ['limit' => 100])
            ->addColumn('autor', 'string', ['limit' => 50])
            ->addColumn('descripcion', 'text')
            ->addColumn('precio', 'decimal', ['precision'=> 10, 'scale' => 2])
            ->addColumn('ruta_a_imagen', 'string', ['limit' => 255])
            ->create();

        $tablaUsuarios = $this->table('usuarios');
        $tablaUsuarios->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('nombre', 'string', ['limit' => 50])
            ->addColumn('apellido', 'string', ['limit' => 50])
            ->addIndex('email', ['unique' => true])
            ->create();

        $tablaReservas = $this->table('reservas');
        $tablaReservas->addColumn('id_usuario', 'integer', ['signed' => false])
            ->addColumn('id_libro', 'integer', ['signed' => false])
            ->addColumn('telefono', 'string', ['limit' => 15])
            ->addColumn('calle', 'string', ['limit' => 50])
            ->addColumn('numero', 'integer')
            ->addColumn('ciudad', 'string', ['limit' => 50])
            ->addColumn('provincia', 'string', ['limit' => 50])
            ->addColumn('codigo_postal', 'string', ['limit' => 10])
            ->addColumn('envio_o_retiro', 'enum', ['values' => ['envio', 'retiro']])
            ->addColumn('fecha_reserva', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('id_usuario', 'usuarios', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('id_libro', 'libros', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
