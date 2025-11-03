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

        header("Location: ../vista/index.php");
        exit();
    } else {
        echo "Credenciales incorrectas. <a href='../vista/login.php'>Volver al login</a>";
    }
}
?>
