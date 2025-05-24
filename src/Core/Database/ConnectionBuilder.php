<?php

namespace PAW\src\Core\Database;

use PDO;
use PDOException;
use Paw\src\Core\Config;
use PAW\src\Core\Traits\Loggable;

class ConnectionBuilder{
    use Loggable;

    public function make(Config $config): PDO{
        try{
            $adapter = $config->get("DB_ADAPTER");
            $hostname = $config->get("DB_HOSTNAME");
            $name = $config->get("DB_NAME");
            $port = $config->get("DB_PORT");
            $charset = $config->get("DB_CHARSET");
            return new PDO(
                "{$adapter}:host={$hostname};port={$port};dbname={$name};charset={$charset}",
                $config->get("DB_USERNAME"),
                $config->get("DB_PASSWORD"),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {
            $this->logger->error("Error conectando a la base de datos", ["Error" => $e->getMessage()]);
            die("Error conectando a la base de datos");
        }
    }
}