
<?php

require_once __DIR__ . '/../includes/funciones.php';
require_once __DIR__ . '/../config/database.php';

$errores = [];
$nombre = '';
$email = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        $errores[] = 'Formulario no válido. Recarga la página.';
    }

    if ($nombre === '' || strlen($nombre) > 100) {
        $errores[] = 'Ingresa un nombre de hasta 100 caracteres.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $errores[] = 'Ingresa un correo electrónico válido.';
    }

    if ($mensaje === '') {
        $errores[] = 'Escribe tu mensaje.';
    }

    if (empty($errores)) {
        try {
            $pdo = conectar_bd();

            $sql = 'INSERT INTO mensajes (nombre, email, mensaje)
                    VALUES (:nombre, :email, :mensaje)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':mensaje' => $mensaje,
            ]);

            header('Location: contacto.php?enviado=1');
            exit;
        } catch (Throwable $e) {
            $errores[] = 'No se pudo guardar el mensaje. Verifica la conexión con la base de datos.';
        }
    }
}

$titulo = 'Contacto';
require __DIR__ . '/../includes/header.php';
?>

<h2>Contáctanos</h2>
<p>Completa el siguiente formulario para enviarnos un mensaje.</p>

<?php if (isset($_GET['enviado'])): ?>
    <p class="exito">¡Tu mensaje se guardó correctamente!</p>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= e($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="contacto.php">

    <input
        type="hidden"
        name="csrf_token"
        value="<?= e(csrf_token()) ?>"
    >

    <label for="nombre">Nombre completo</label>
    <input
        type="text"
        id="nombre"
        name="nombre"
        maxlength="100"
        value="<?= e($nombre) ?>"
        required
    >

    <label for="email">Correo electrónico</label>
    <input
        type="email"
        id="email"
        name="email"
        maxlength="150"
        value="<?= e($email) ?>"
        required
    >

    <label for="mensaje">Tu mensaje</label>
    <textarea
        id="mensaje"
        name="mensaje"
        rows="5"
        required
    ><?= e($mensaje) ?></textarea>

    <button type="submit">Enviar mensaje</button>

</form>

<?php require __DIR__ . '/../includes/footer.php'; ?>
