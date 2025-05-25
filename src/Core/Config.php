<?php

namespace PAW\src\Core;

use Dotenv\Dotenv;

class config{
    private array $configs;

    public function __construct()
    {
        $envPath = __DIR__ . '/../../.env';
        
        if (file_exists($envPath)) {
            $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }

        $this->configs["LOG_LEVEL"] = getenv("LOG_LEVEL") ?? "INFO";
        $path = getenv("LOG_PATH") ?? "/log/app.log";
        $this->configs["LOG_PATH"] = $this->joinPaths('..' . $path);
        $this->configs["SMTP_HOST"] = getenv("SMTP_HOST") ?? "smtp.gmail.com";
        $this->configs["SMTP_PORT"] = getenv("SMTP_PORT") ?? "587";
        $this->configs["SMTP_USERNAME"] = getenv("SMTP_USERNAME");
        $this->configs["SMTP_PASSWORD"] = getenv("SMTP_PASSWORD");
        $this->configs["SMTP_FROM_EMAIL"] = getenv("SMTP_FROM_EMAIL");
        $this->configs["SMTP_FROM_NAME"] = getenv("SMTP_FROM_NAME") ?? "Sistema de Reservas";
        $this->configs["DB_ADAPTER"] = getenv("DB_ADAPTER") ?? "mysql";
        $this->configs["DB_HOSTNAME"] = getenv("DB_HOSTNAME") ?? "localhost";
        $this->configs["DB_NAME"] = getenv("DB_NAME") ?? "pawprints";
        $this->configs["DB_USERNAME"] = getenv("DB_USERNAME") ?? "root";
        $this->configs["DB_PASSWORD"] = getenv("DB_PASSWORD") ?? "";
        $this->configs["DB_PORT"] = getenv("DB_PORT") ?? "3306";
        $this->configs["DB_CHARSET"] = getenv("DB_CHARSET") ?? "utf8";
    }


    public function joinPaths(){
        $paths = array();
        foreach (func_get_args() as $arg) {
            if ($arg != ''){
                $paths[] = $arg;
            }
        }
        return preg_replace('#/+#', '/', join('/', $paths));
    }

    public function get($name){
        return $this->configs[$name] ?? null;
    }
}