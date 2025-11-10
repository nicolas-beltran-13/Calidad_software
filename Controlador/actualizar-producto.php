<?php
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Conexion();
    $conn = $db->getConexion();

    try {
        $id_producto = $_POST['id_producto'];
        $nombreProducto = $_POST['nombreProducto'];
        $precio = $_POST['Precio'];
        $descripcion = $_POST['Descripcion'];
        $cantidad = $_POST['cantidad'];
        $id_tipo_producto = $_POST['id_tipo_producto'];
        $valordeStock = $_POST['valordeStock'];

        // Verificar si se actualiza la imagen
        $updateFoto = false;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
            $updateFoto = true;
        }

        // Actualizar el producto
        if ($updateFoto) {
            $query = "UPDATE producto SET nombreProducto = :nombreProducto, Precio = :precio, Descripcion = :descripcion, foto = :foto, cantidad = :cantidad, id_tipo_producto = :id_tipo_producto, valordeStock = :valordeStock WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
        } else {
            $query = "UPDATE producto SET nombreProducto = :nombreProducto, Precio = :precio, Descripcion = :descripcion, cantidad = :cantidad, id_tipo_producto = :id_tipo_producto, valordeStock = :valordeStock WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
        }

        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_tipo_producto', $id_tipo_producto);
        $stmt->bindParam(':valordeStock', $valordeStock);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Producto actualizado exitosamente";
        } else {
            throw new Exception('Error al actualizar el producto');
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header('Location: ../vista/admin-dashboard.php');
exit();
?>
