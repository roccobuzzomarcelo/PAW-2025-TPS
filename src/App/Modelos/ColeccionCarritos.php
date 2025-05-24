<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use PAW\src\App\Modelos\Carrito;

class ColeccionCarritos extends Modelo
{
    public $table = 'carrito_items';
    
    public function agregar($datos){
        return $this->queryBuilder->insert($this->table, $datos);
    }

    public function getItems($usuario_id){
        $parametros = [
            'condiciones' => ['usuario_id = :usuario_id'],
            'binds' => [':usuario_id' => $usuario_id]
        ];
        $items = $this->queryBuilder->select($this->table, $parametros);
        $libros = [];
        foreach ($items as $item){
            // Hacer consulta del libro correspondiente
            $libro = new Libro;
            $libro->setQueryBuilder($this->queryBuilder);
            $libro->load([$item['libro_id']]);
            $libros[] = $libro;
        }
        return $libros;
    }
}