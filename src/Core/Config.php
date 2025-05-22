<?php

namespace PAW\src\Core;

use Dotenv\Dotenv;

class config{
    private array $configs;

    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $this->configs["LOG_LEVEL"] = getenv("LOG_LEVEL") !== false ? getenv("LOG_LEVEL") : "INFO";
        $path = getenv("LOG_PATH") !== false ? getenv("LOG_PATH") : "/log/app.log";
        $this->configs["LOG_PATH"] = $this->joinPaths('..'.$path);
        $this->configs["SMTP_HOST"] = getenv("SMTP_HOST") !== false ? getenv("SMTP_HOST") : "smtp.gmail.com";
        $this->configs["SMTP_PORT"] = getenv("SMTP_PORT") !== false ? getenv("SMTP_PORT") : "587";
        $this->configs["SMTP_USERNAME"] = getenv("SMTP_USERNAME");
        $this->configs["SMTP_PASSWORD"] = getenv("SMTP_PASSWORD");
        $this->configs["SMTP_FROM_EMAIL"] = getenv("SMTP_FROM_EMAIL");
        $this->configs["SMTP_FROM_NAME"] = getenv("SMTP_FROM_NAME") !== false ? getenv("SMTP_FROM_NAME") : "Sistema de Reservas";
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