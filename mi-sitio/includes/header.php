
<?php
require_once __DIR__ . '/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo ?? 'Mi sitio') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mi sitio</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="contacto.php">Contacto</a>
            <a href="mensajes.php">Mensajes</a>
        </nav>
    </header>
    <main>
