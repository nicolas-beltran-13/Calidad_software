<?php
require_once '../modelo/conexion.php';

$db = new Conexion();
$conn = $db->getConexion();

$query = "SELECT p.id_producto, p.nombreProducto, p.Precio, p.Descripcion, p.cantidad, t.nombreTipo, p.foto
          FROM producto p
          JOIN tipo_producto t ON p.id_tipo_producto = t.id_tipo_producto
          WHERE p.cantidad > 0
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
