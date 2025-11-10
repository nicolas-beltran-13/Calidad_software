<?php
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

$db = new Conexion();
$conn = $db->getConexion();

$query = "SELECT p.id_producto, p.nombreProducto, p.Precio, p.Descripcion, p.cantidad, p.valordeStock, t.nombreTipo, p.foto
          FROM producto p
          JOIN tipo_producto t ON p.id_tipo_producto = t.id_tipo_producto
          ORDER BY p.id_producto DESC";

$result = $conn->query($query);
$productos = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Convertir la imagen BLOB a base64 si existe
    if ($row['foto']) {
        $row['foto'] = base64_encode($row['foto']);
    }
    $productos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($productos);
?>
