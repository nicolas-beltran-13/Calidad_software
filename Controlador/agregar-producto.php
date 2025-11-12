<?php
session_start();
require_once '../modelo/conexion.php';

use Exception; // Importar la clase Exception en caso de que estés usando un framework que soporte autoloading

// Verificar si el usuario tiene sesión y es administrador
if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: ../vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Conexion();
    $conn = $db->getConexion(); // Obtener conexión a la base de datos

    try {
        // Preparar los datos recibidos desde el formulario
        $nombreProducto = $_POST['nombreProducto'];
        $precio = $_POST['Precio'];
        $descripcion = $_POST['Descripcion'];
        $cantidad = $_POST['cantidad'];
        $id_tipo_producto = $_POST['id_tipo_producto'];
        $valordeStock = $_POST['valordeStock'];

        // Manejar la imagen (foto)
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Usamos file_get_contents para obtener el contenido binario de la imagen
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } else {
            throw new Exception('Error al cargar la imagen');
        }

        // Insertar los datos en la base de datos
        $query = "INSERT INTO producto (nombreProducto, Precio, Descripcion, foto, cantidad, id_tipo_producto, valordeStock) 
                 VALUES (:nombreProducto, :precio, :descripcion, :foto, :cantidad, :id_tipo_producto, :valordeStock)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB); // Usamos PDO::PARAM_LOB para manejar datos binarios
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_tipo_producto', $id_tipo_producto);
        $stmt->bindParam(':valordeStock', $valordeStock);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Producto agregado exitosamente";
            header('Location: ../vista/admin-dashboard.php');
            exit();
        } else {
            throw new Exception('Error al guardar el producto');
        }
    } catch (Exception $e) {
        // En caso de error, almacenar el mensaje de error en la sesión
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('Location: ../vista/admin-dashboard.php');
        exit();
    }
}
?>
