<?php
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $db = new Conexion();
    $conn = $db->getConexion();

    $id_producto = $_GET['id'];

    $query = "SELECT p.id_producto, p.nombreProducto, p.Precio, p.Descripcion, p.cantidad, p.valordeStock, p.id_tipo_producto, t.nombreTipo, p.foto
              FROM producto p
              JOIN tipo_producto t ON p.id_tipo_producto = t.id_tipo_producto
              WHERE p.id_producto = :id_producto";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // Convertir la imagen BLOB a base64 si existe
        if ($producto['foto']) {
            $producto['foto'] = base64_encode($producto['foto']);
        }
        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
}
?>
