<?php
require_once 'modelo/conexion.php';
$db = new Conexion();
$conn = $db->getConexion();

$tipos = [
    'Carnes Frías y Embutidos',
    'Lácteos y Quesos',
    'Salsas, Aderezos y Condimentos',
    'Insumos de Repostería y Panadería',
    'Abarrotes y Granos Secos'
];

foreach ($tipos as $tipo) {
    $stmt = $conn->prepare('INSERT INTO tipo_producto (nombreTipo) VALUES (?)');
    $stmt->execute([$tipo]);
}

echo 'Tipos de producto insertados correctamente';
?>
