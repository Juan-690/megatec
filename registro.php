<?php
session_start();
require_once 'conexion.php';

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (!empty($correo) && !empty($password)) {
        // Validar límite de longitud según la BD (varchar(16))
        if (strlen($password) > 16) {
            $error = "La contraseña no puede tener más de 16 caracteres.";
        } else {
            // Verificar si el correo ya existe
            $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
            $check->bind_param("s", $correo);
            $check->execute();
            $res = $check->get_result();

            if ($res->num_rows > 0) {
                $error = "El correo electrónico ya está registrado.";
            } else {
                // Insertar el nuevo usuario
                $stmt = $conn->prepare("INSERT INTO usuarios (correo, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $correo, $password);

                if ($stmt->execute()) {
                    $exito = "¡Cuenta creada con éxito! Redirigiendo al login...";
                    header("refresh:2;url=login.php");
                } else {
                    $error = "Ocurrió un error al registrar el usuario.";
                }
                $stmt->close();
            }
            $check->close();
        }
    } else {
        $error = "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Megatec - Crear Cuenta</title>
    <link rel="stylesheet" href="auth-estilo.css">
</head>
<body class="login-body">

    <div class="login-background"></div>

    <header class="login-header">
        <div class="login-logo">
            Megatec<span>●</span>
            <small>compra</small>
        </div>
    </header>

    <main class="login-container">
        <div class="login-card">
            <h1>Crear cuenta</h1>
            <p class="login-subtitle">Regístrate para comprar en Megatec</p>

            <?php if (!empty($error)): ?>
                <p class="login-message alert-error"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($exito)): ?>
                <p class="login-message alert-success"><?php echo $exito; ?></p>
            <?php endif; ?>

            <form action="registro.php" method="POST">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com">

                <label for="password">Contraseña (máx. 16 caracteres)</label>
                <input type="password" id="password" name="password" maxlength="16" required placeholder="••••••••">

                <button type="submit" class="btn-login">Registrarse</button>
            </form>

            <div class="create-account">
                ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
            </div>
        </div>
    </main>

</body>
</html>