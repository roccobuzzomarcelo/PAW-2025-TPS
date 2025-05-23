<?php

namespace PAW\src\Core\Database;

use PAW\src\Core\Traits\Loggable;
use PDO;

class QueryBuilder
{
    use Loggable;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function select($tabla, $parametros = []){
        $condiciones = [];
        $binds = [];

        // Búsqueda por texto (consulta)
        if (isset($parametros['consulta'])) {
            $condiciones[] = "(titulo LIKE :consulta OR autor LIKE :consulta)";
            $binds[':consulta'] = '%' . $parametros['consulta'] . '%';
        }

        // Filtro por IDs
        if (isset($parametros['ids']) && is_array($parametros['ids']) && count($parametros['ids']) > 0) {
            $placeholders = [];
            foreach ($parametros['ids'] as $i => $id) {
                $ph = ":id_$i";
                $placeholders[] = $ph;
                $binds[$ph] = $id;
            }
            $condiciones[] = "id IN (" . implode(",", $placeholders) . ")";
        }

        // Otras condiciones libres si las hay
        if (isset($parametros['condiciones']) && is_array($parametros['condiciones'])) {
            foreach ($parametros['condiciones'] as $cond) {
                $condiciones[] = $cond;
            }
        }

        $where = count($condiciones) > 0 ? implode(" AND ", $condiciones) : "1 = 1";

        $query = "SELECT * FROM {$tabla} WHERE {$where}";

        // Paginación
        if (isset($parametros['limit'])) {
            $query .= " LIMIT :limit";
            $binds[':limit'] = (int)$parametros['limit'];
        }
        if (isset($parametros['offset'])) {
            $query .= " OFFSET :offset";
            $binds[':offset'] = (int)$parametros['offset'];
        }

        $sentencia = $this->pdo->prepare($query);

        foreach ($binds as $clave => $valor) {
            $tipo = is_int($valor) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $sentencia->bindValue($clave, $valor, $tipo);
        }

        $sentencia->setFetchMode(\PDO::FETCH_ASSOC);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function insert(){
    
    }

    public function update(){

    }

    public function delete(){
    
    }
    public function count(string $tabla, array $parametros = []): int
    {
        $condiciones = [];
        $binds = [];

        // Filtro por búsqueda textual
        if (isset($parametros['consulta'])) {
            $condiciones[] = "(titulo LIKE :consulta OR autor LIKE :consulta)";
            $binds[':consulta'] = '%' . $parametros['consulta'] . '%';
        }

        // Filtro por IDs
        if (isset($parametros['ids']) && is_array($parametros['ids']) && count($parametros['ids']) > 0) {
            $placeholders = [];
            foreach ($parametros['ids'] as $i => $id) {
                $ph = ":id_$i";
                $placeholders[] = $ph;
                $binds[$ph] = $id;
            }
            $condiciones[] = "id IN (" . implode(",", $placeholders) . ")";
        }

        // Otras condiciones personalizadas
        if (isset($parametros['condiciones']) && is_array($parametros['condiciones'])) {
            foreach ($parametros['condiciones'] as $cond) {
                $condiciones[] = $cond;
            }
        }

        $where = count($condiciones) > 0 ? " WHERE " . implode(" AND ", $condiciones) : "";

        $query = "SELECT COUNT(*) as total FROM {$tabla}{$where}";
        $stmt = $this->pdo->prepare($query);

        foreach ($binds as $clave => $valor) {
            $tipo = is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($clave, $valor, $tipo);
        }

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$resultado['total'];
    }
}