<?php
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $db = new Conexion();
    $conn = $db->getConexion();

    try {
        $id_producto = $_POST['id_producto'];

        // Eliminar el producto
        $query = "DELETE FROM producto WHERE id_producto = :id_producto";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_producto', $id_producto);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Producto eliminado exitosamente";
        } else {
            throw new Exception('Error al eliminar el producto');
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header('Location: ../vista/admin-dashboard.php');
exit();
?>
