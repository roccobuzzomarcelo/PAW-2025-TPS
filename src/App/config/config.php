<?php

// Incluir el autoload de Composer
require_once __DIR__ . '/../../../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar las variables de entorno desde el archivo .env en la raíz del proyecto
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Devolver la configuración usando las variables del entorno
return [
    'smtp' => [
        'host' => $_ENV['SMTP_HOST'],
        'port' => $_ENV['SMTP_PORT'],
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'from_email' => $_ENV['SMTP_FROM_EMAIL'],
        'from_name' => $_ENV['SMTP_FROM_NAME'],
    ]
];
