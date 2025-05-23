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

    public function select($tabla, $condiciones = "", $parametros = [], $limit = null, $offset = null){
        $query = "SELECT * FROM {$tabla}";
        if (!empty($condiciones)) {
            $query .= " WHERE " . $condiciones;
        }
        if ($limit !== null) {
            $query .= " LIMIT :limit";
            $parametros[':limit'] = (int)$limit;
        }
        if ($offset !== null) {
            $query .= " OFFSET :offset";
            $parametros[':offset'] = (int)$offset;
        }
        $sentencia = $this->pdo->prepare($query);
        foreach ($parametros as $clave => $valor) {
            $tipo = is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $sentencia->bindValue($clave, $valor, $tipo);
        }
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function insert(){
    
    }

    public function update(){

    }

    public function delete(){
    
    }
    public function count($tabla, $condiciones = "", $parametros = [])
    {
        $query = "SELECT COUNT(*) as total FROM {$tabla}";
        if (!empty($condiciones)) {
            $query .= " WHERE " . $condiciones;
        }

        $stmt = $this->pdo->prepare($query);
        foreach ($parametros as $clave => $valor) {
            $tipo = is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($clave, $valor, $tipo);
        }

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $resultado['total'];
    }

}