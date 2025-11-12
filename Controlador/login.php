<?php
require_once 'init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = sanear($_POST['email']);
    $contraseña = sanear($_POST['password']);

    if($usuario->login($gmail, $contraseña)) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nombre'] = $usuario->nombre;

        // Normalizar rol para facilitar comprobación
        $_SESSION['usuario_rol'] = $usuario->rol;
        $normalized = mb_strtolower(preg_replace('/\s+/u', '', $usuario->rol));
        $_SESSION['usuario_rol_normalized'] = $normalized;
        $_SESSION['is_admin'] = ($normalized === 'admin');

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