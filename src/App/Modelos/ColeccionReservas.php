<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use PAW\src\App\Modelos\Reserva;
use PAW\src\App\Modelos\Libro;
use PAW\src\App\Modelos\Usuario;

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
}