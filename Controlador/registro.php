<?php
require_once 'init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanear inputs
    $nombre = sanear($_POST['nombre']);
    $NumeroIdentificacion = sanear($_POST['numero_identificacion']);
    $direccion = sanear($_POST['direccion']);
    $telefono = sanear($_POST['telefono']);
    $rol = 'Cliente';
    $gmail = sanear($_POST['email']);
    $contraseña = sanear($_POST['password']);

    if($usuario->registrar($nombre, $NumeroIdentificacion, $direccion, $telefono, $rol, $gmail, $contraseña)) {
        echo "Registro exitoso. <a href='../vista/login.php'>Iniciar sesión</a>";
    } else {
        echo "Error en el registro. <a href='../vista/registro.php'>Volver al registro</a>";
    }
}
?>
