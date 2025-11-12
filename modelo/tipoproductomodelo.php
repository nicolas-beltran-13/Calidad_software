<?php
require_once __DIR__ . '/conexion.php';

function obtenerTiposProducto() {
    $db = new Conexion();
    $conn = $db->getConexion();
    $query = "SELECT id_tipo_producto, nombreTipo FROM tipo_producto";
    return $conn->query($query);
}
?>