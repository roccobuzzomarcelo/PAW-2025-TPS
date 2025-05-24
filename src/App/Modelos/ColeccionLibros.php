<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use PAW\src\App\Modelos\Libro;

class ColeccionLibros extends Modelo
{
    public $table = 'libros';

    public function get($id){
        $libro = new Libro;
        $libro->setQueryBuilder($this->queryBuilder);
        $libro->load($id);
        return $libro;
    }

    public function getAll(){
        $libros = $this->queryBuilder->select($this->table);
        $coleccionLibros = [];
        foreach ($libros as $libro){
            $nuevoLibro = new Libro;
            $nuevoLibro->set($libro);
            $coleccionLibros[] = $nuevoLibro;
        }
        return $coleccionLibros;
    }

    public function getLibrosPaginados($consulta = null, $ids = null, $pagina = 1, $librosPorPagina = 10)
    {
        $parametros = [];

        if ($consulta !== null) {
            $parametros['consulta'] = $consulta;
        }

        if ($ids !== null && is_array($ids)) {
            $parametros['ids'] = $ids;
        }

        $parametros['limit'] = $librosPorPagina;
        $parametros['offset'] = ($pagina - 1) * $librosPorPagina;

        // 1) Obtener libros paginados
        $libros = $this->queryBuilder->select('libros', $parametros);

        $coleccionLibros = [];
        foreach ($libros as $libro) {
            $nuevoLibro = new Libro;
            $nuevoLibro->set($libro);
            $coleccionLibros[] = $nuevoLibro;
        }

        // 2) Contar total sin limit ni offset, pero con mismas condiciones
        $parametrosSinLimite = $parametros;
        unset($parametrosSinLimite['limit'], $parametrosSinLimite['offset']);
        $totalRegistros = $this->queryBuilder->count('libros', $parametrosSinLimite);

        $totalPaginas = $librosPorPagina > 0 ? ceil($totalRegistros / $librosPorPagina) : 1;

        return [
            'libros' => $coleccionLibros,
            'totalPaginas' => $totalPaginas
        ];
    }

    public function crear($datos){
        return $this->queryBuilder->insert($this->table, $datos);
    }

}