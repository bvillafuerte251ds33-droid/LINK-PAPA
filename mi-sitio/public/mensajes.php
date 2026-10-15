
<?php

require_once __DIR__ . '/../includes/funciones.php';
require_once __DIR__ . '/../config/database.php';

$titulo = 'Mensajes recibidos';
$mensajes = [];
$error = '';

try {
    $pdo = conectar_bd();

    $sql = 'SELECT id, nombre, email, mensaje, creado_en
            FROM mensajes
            ORDER BY id DESC';

    $stmt = $pdo->query($sql);
    $mensajes = $stmt->fetchAll();
} catch (Throwable $e) {
    $error = 'No se pudieron cargar los mensajes. Verifica la conexión.';
}

require __DIR__ . '/../includes/header.php';
?>

<h2>Mensajes recibidos</h2>
<p>Consulta los mensajes registrados en la base de datos.</p>

<?php if ($error !== ''): ?>
    <p class="errores"><?= e($error) ?></p>

<?php elseif (count($mensajes) === 0): ?>
    <p>Todavía no hay mensajes registrados.</p>

<?php else: ?>

    <p>Total de mensajes: <strong><?= count($mensajes) ?></strong></p>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($mensajes as $item): ?>
                    <tr>
                        <td><?= (int) $item['id'] ?></td>
                        <td><?= e($item['nombre']) ?></td>
                        <td><?= e($item['email']) ?></td>
                        <td><?= nl2br(e($item['mensaje'])) ?></td>
                        <td><?= e($item['creado_en']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<p><a href="contacto.php">Volver al formulario de contacto</a></p>

<?php require __DIR__ . '/../includes/footer.php'; ?>
