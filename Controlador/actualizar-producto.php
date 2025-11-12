<?php
session_start();

// Uso de namespaces y autoloading si está disponible
// Si tienes clases en un namespace, deberías usar `use` para importarlas, por ejemplo:
// use MiProyecto\Modelo\Conexion;

require_once '../modelo/conexion.php';  // Si no usas namespaces, mantenemos el require_once

// Verificar si el usuario tiene acceso de administrador
if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Conexion();
    $conn = $db->getConexion();

    try {
        // Obtener los datos del formulario
        $id_producto = $_POST['id_producto'];
        $nombreProducto = $_POST['nombreProducto'];
        $precio = $_POST['Precio'];
        $descripcion = $_POST['Descripcion'];
        $cantidad = $_POST['cantidad'];
        $id_tipo_producto = $_POST['id_tipo_producto'];
        $valordeStock = $_POST['valordeStock'];

        // Verificar si se actualiza la imagen
        $updateFoto = false;
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
            $updateFoto = true;
        }

        // Preparar y ejecutar la actualización del producto
        if ($updateFoto) {
            $query = "UPDATE producto SET nombreProducto = :nombreProducto, Precio = :precio, Descripcion = :descripcion, foto = :foto, cantidad = :cantidad, id_tipo_producto = :id_tipo_producto, valordeStock = :valordeStock WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
        } else {
            $query = "UPDATE producto SET nombreProducto = :nombreProducto, Precio = :precio, Descripcion = :descripcion, cantidad = :cantidad, id_tipo_producto = :id_tipo_producto, valordeStock = :valordeStock WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
        }

        // Bind parameters
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_tipo_producto', $id_tipo_producto);
        $stmt->bindParam(':valordeStock', $valordeStock);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Producto actualizado exitosamente";
        } else {
            throw new ProductUpdateException('Error al actualizar el producto');
        }
    } catch (ProductUpdateException $e) {
        $_SESSION['error'] = "Error específico: " . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header('Location: ../vista/admin-dashboard.php');
exit();

// Definición de excepción específica para la actualización de productos
class ProductUpdateException extends Exception {}
?>
