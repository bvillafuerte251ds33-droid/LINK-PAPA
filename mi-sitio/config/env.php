<?php
declare(strict_types=1);

function cargar_env(string $archivo): void
{
    if (!is_file($archivo)) {
        throw new RuntimeException('No se encontró el archivo .env');
    }

    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        if ($linea === '' || str_starts_with($linea, '#')) {
            continue;
        }

        if (!str_contains($linea, '=')) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        if ($clave !== '') {
            $_ENV[$clave] = $valor;
        }
    }
}

cargar_env(__DIR__ . '/../.env');