<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use PAW\src\App\Modelos\Reserva;
use PAW\src\App\Modelos\Libro;

class ColeccionReservas extends Modelo
{
    public $table = 'reservas';

    public function getLibro($id){
        $libro = new Libro;
        $libro->setQueryBuilder($this->queryBuilder);
        $libro->load($id);
        return $libro;
    }

    public function crear($datos){
        return $this->queryBuilder->insert($this->table, $datos);
    }

    public function getAll(){
        $reservas = $this->queryBuilder->select($this->table);
        $coleccionReservas = [];
        foreach ($reservas as $reserva){
            $nuevaReserva = new reserva;
            $nuevaReserva->set($reserva);
            $coleccionReservas[] = $nuevaReserva;
        }
        return $coleccionReservas;
    }

    public function getReservas($consulta = null)
    {
        $parametros = [];
        $condiciones = [];
        $binds = [];

        if (!empty($consulta)) {
            $q = "%{$consulta}%";
            $condiciones[] = 'nombre LIKE :q OR email LIKE :q OR libro_id LIKE :q OR usuario_id LIKE :q';
            $binds[':q'] = $q;
        }

        if (!empty($condiciones)) {
            $parametros['condiciones'] = $condiciones;
            $parametros['binds'] = $binds;
        }

        $rows = $this->queryBuilder->select($this->table, $parametros);

        $coleccion = [];
        foreach ($rows as $datos) {
            $r = new Reserva();
            $r->setQueryBuilder($this->queryBuilder);
            $r->set($datos);
            $coleccion[] = $r;
        }

        return $coleccion;
    }


}