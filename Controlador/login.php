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
        // Normalizar rol: eliminar espacios y usar minúsculas para la comparación
    // Store raw role and a normalized version (remove all whitespace and lowercase in multibyte)
    $_SESSION['usuario_rol'] = $usuario->rol;
    $normalized = mb_strtolower(preg_replace('/\s+/u', '', $usuario->rol));
    $_SESSION['usuario_rol_normalized'] = $normalized;
    // Log role for debugging
    error_log('[login] usuario id=' . $_SESSION['usuario_id'] . ' role_raw=' . var_export($_SESSION['usuario_rol'], true) . ' normalized=' . $normalized);
    // set helper flag
    $_SESSION['is_admin'] = ($normalized === 'admin');

        // Redirigir según el rol del usuario
        if ($normalized === 'admin') {
            header("Location: ../vista/admin-dashboard.php");
        } else {
            header("Location: ../vista/index.php");
        }
        exit();
    } else {
        echo "Credenciales incorrectas. <a href='../vista/login.php'>Volver al login</a>";
    }
}
?>
