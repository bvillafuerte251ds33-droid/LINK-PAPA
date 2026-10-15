<?php
declare(strict_types=1);

require_once __DIR__ . '/env.php';

function conectar_bd(): PDO
{
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $puerto = $_ENV['DB_PORT'] ?? '5432';
    $base = $_ENV['DB_NAME'] ?? 'sitio_db';
    $usuario = $_ENV['DB_USER'] ?? 'sitio_user';
    $clave = $_ENV['DB_PASS'] ?? '';

    $dsn = "pgsql:host=$host;port=$puerto;dbname=$base";

    return new PDO($dsn, $usuario, $clave, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}