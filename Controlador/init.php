<?php
session_start();
require_once '../modelo/conexion.php';
require_once '../modelo/Usuario.php';

// Crear conexión y objeto usuario para reutilizar
$database = new Conexion();
$db = $database->getConexion();
$usuario = new Usuario($db);


function sanear($dato) {
    return htmlspecialchars(strip_tags($dato));
}
?>