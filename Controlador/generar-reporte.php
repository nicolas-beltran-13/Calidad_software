<?php
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

$db = new Conexion();
$conn = $db->getConexion();

$query = "SELECT p.id_producto, p.nombreProducto, p.Precio, p.Descripcion, p.cantidad, p.valordeStock, t.nombreTipo
          FROM producto p
          JOIN tipo_producto t ON p.id_tipo_producto = t.id_tipo_producto
          ORDER BY p.id_producto ASC";

$result = $conn->query($query);

// Configurar headers para descarga de Excel
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte_productos_' . date('Y-m-d_H-i-s') . '.xls');

// Crear tabla HTML que Excel puede interpretar
echo "<html>";
echo "<head>";
echo "<meta charset='utf-8'>";
echo "<style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; font-weight: bold; }
    tr:nth-child(even) { background-color: #f9f9f9; }
</style>";
echo "</head>";
echo "<body>";
echo "<h2>Reporte de Productos - DondePepito</h2>";
echo "<p>Generado el: " . date('d/m/Y H:i:s') . "</p>";
echo "<table>";
echo "<tr>";
echo "<th>ID Producto</th>";
echo "<th>Nombre Producto</th>";
echo "<th>Tipo Producto</th>";
echo "<th>Precio</th>";
echo "<th>Descripción</th>";
echo "<th>Cantidad en Stock</th>";
echo "<th>Stock Mínimo</th>";
echo "</tr>";

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id_producto']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreProducto']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nombreTipo']) . "</td>";
    echo "<td>$" . htmlspecialchars($row['Precio']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Descripcion']) . "</td>";
    echo "<td>" . htmlspecialchars($row['cantidad']) . "</td>";
    echo "<td>" . htmlspecialchars($row['valordeStock']) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</body>";
echo "</html>";
exit();
?>
