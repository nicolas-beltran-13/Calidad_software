<?php
session_start();
require_once '../modelo/conexion.php';
require_once '../modelo/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Conexion();
    $db = $database->getConexion();

    $usuario = new Usuario($db);

    $gmail = htmlspecialchars(strip_tags($_POST['email']));
    $contraseña = htmlspecialchars(strip_tags($_POST['password']));

    if($usuario->login($gmail, $contraseña)) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nombre'] = $usuario->nombre;
        $_SESSION['usuario_rol'] = $usuario->rol;

        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Salsamentaria</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Barra de navegación (logo sin enlace, sin botones) -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <div class="logo">
                    <i class="fas fa-store"></i>
                    Salsamentaria
                </div>
            </div>
            <!-- nav-right eliminado intencionalmente -->
        </div>
    </nav>

    <div class="form-container">
        <h2><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red; margin-bottom: 10px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php"><i class="fas fa-user-plus"></i> Regístrate aquí</a></p>
    </div>
</body>
</html>
