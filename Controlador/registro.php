<?php
require_once '../modelo/conexion.php';
require_once '../modelo/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Conexion();
    $db = $database->getConexion();

    $usuario = new Usuario($db);

    $nombre = htmlspecialchars(strip_tags($_POST['nombre']));
    $NumeroIdentificacion = htmlspecialchars(strip_tags($_POST['numero_identificacion']));
    $direccion = htmlspecialchars(strip_tags($_POST['direccion']));
    $telefono = htmlspecialchars(strip_tags($_POST['telefono']));
    $rol = 'Cliente'; // Por defecto, los usuarios registrados son clientes
    $gmail = htmlspecialchars(strip_tags($_POST['email']));
    $contraseña = htmlspecialchars(strip_tags($_POST['password']));

    if($usuario->registrar($nombre, $NumeroIdentificacion, $direccion, $telefono, $rol, $gmail, $contraseña)) {
        echo "Registro exitoso. <a href='../vista/login.html'>Iniciar sesión</a>";
    } else {
        echo "Error en el registro. <a href='../vista/registro.html'>Volver al registro</a>";
    }
}
?>
