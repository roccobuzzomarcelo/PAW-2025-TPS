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
            ->addColumn('descripcion', 'string', ['limit' => 500])
            ->addColumn('precio', 'string', ['limit'=> 15])
            ->addColumn('ruta_a_imagen', 'string', ['limit' => 100])
            ->create();

        $tablaUsuarios = $this->table('usuarios');
        $tablaUsuarios->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('nombre', 'string', ['limit' => 50])
            ->addColumn('apellido', 'string', ['limit' => 50])
            ->create();

        $tablaReservas = $this->table('reservas');
        $tablaReservas->addColumn('id_libro', 'integer', ['signed' => false])
            ->addColumn('nombre', 'string', ['limit' => 50])
            ->addColumn('apellido', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('telefono', 'string', ['limit' => 15])
            ->addColumn('calle', 'string' , ['limit' => 50])
            ->addColumn('numero', 'integer')
            ->addColumn('ciudad', 'string', ['limit' => 50])
            ->addColumn('provincia', 'string', ['limit' => 50])
            ->addColumn('codigo_postal', 'string', ['limit' => 10])
            ->addColumn('envio_o_retiro', 'string', ['limit' => 10])
            ->addForeignKey('id_libro', 'libros', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
