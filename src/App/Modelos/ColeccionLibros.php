<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use PAW\src\App\Modelos\Libro;

class ColeccionLibros extends Modelo
{
    public $table = 'libro';

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
        $offset = ($pagina - 1) * $librosPorPagina;
        $condiciones = [];
        $parametros = [];

        if ($consulta !== null) {
            $condiciones[] = "(titulo LIKE :consulta OR autor LIKE :consulta)";
            $parametros[':consulta'] = '%' . $consulta . '%';
        }

        if ($ids !== null && is_array($ids) && count($ids) > 0) {
            $placeholders = [];
            foreach ($ids as $index => $id) {
                $ph = ":id_$index";
                $placeholders[] = $ph;
                $parametros[$ph] = $id;
            }
            $condiciones[] = "id IN (" . implode(",", $placeholders) . ")";
        }

        $where = implode(" AND ", $condiciones);

        // 1) Obtener libros paginados
        $libros = $this->queryBuilder->select('libros', $where, $parametros, $librosPorPagina, $offset);

        // 2) Obtener total de registros (sin límite ni offset), pero con mismas condiciones
        $totalRegistros = $this->queryBuilder->count('libros', $where, $parametros);

        $totalPaginas = $librosPorPagina > 0 ? ceil($totalRegistros / $librosPorPagina) : 1;

        return [
            'libros' => $libros,
            'totalPaginas' => $totalPaginas
        ];
    }

}