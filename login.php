<?php
session_start();
require_once 'conexion.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (!empty($correo) && !empty($password)) {
        // Consulta usando los nombres exactos de la BD: correo y password
        $stmt = $conn->prepare("SELECT id_usuario, password FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            // Verifica la contraseña
            if ($password === $usuario['password'] || password_verify($password, $usuario['password'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                
                // Redirección exitosa a tu página principal
                header("Location: inicio.html");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El correo electrónico no está registrado.";
        }
        $stmt->close();
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
    <title>Megatec - Iniciar Sesión</title>
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
            <h1>Iniciar sesión</h1>
            <p class="login-subtitle">Ingresa a tu cuenta de Megatec</p>

            <?php if (!empty($error)): ?>
                <p class="login-message alert-error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com">

                <div class="password-title">
                    <label for="password">Contraseña</label>
                </div>
                <input type="password" id="password" name="password" maxlength="16" required placeholder="••••••••">

                <button type="submit" class="btn-login">Ingresar</button>
            </form>

            <div class="create-account">
                ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
            </div>
        </div>
    </main>

</body>
</html>