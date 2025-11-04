<?php
session_start();
// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || (empty($_SESSION['is_admin']) && strtolower(trim($_SESSION['usuario_rol'] ?? '')) !== 'admin')) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - DondePepito</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#8B1F1F', // Color principal (guinda)
                    secondary: '#5C1414', // Color secundario (guinda oscuro)
                    accent: '#D4AF37', // Color acento (dorado)
                    background: '#F9F9F9', // Fondo claro
                    surface: '#FFFFFF', // Superficie
                }
            }
        }
    }
    </script>
</head>

<body class="bg-background">
    <!-- Barra lateral -->
    <div class="fixed left-0 top-0 h-screen w-64 bg-primary text-white shadow-lg">
        <div class="p-6 border-b border-secondary">
            <div class="flex items-center space-x-3">
                <i class="fas fa-store text-2xl"></i>
                <span class="text-xl font-bold">DondePepito</span>
            </div>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary">
                        <i class="fas fa-box"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Contenido principal -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Productos</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Bienvenido,
                    <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador'); ?></span>
                <a href="../Controlador/logout.php"
                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>

        <!-- Formulario de producto -->
        <div class="bg-surface p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Agregar Nuevo Producto</h2>
            <form action="../Controlador/agregar-producto.php" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="nombreProducto">
                            Nombre del Producto
                        </label>
                        <input type="text" id="nombreProducto" name="nombreProducto" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="Precio">
                            Precio
                        </label>
                        <input type="number" id="Precio" name="Precio" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="cantidad">
                            Cantidad en Stock
                        </label>
                        <input type="number" id="cantidad" name="cantidad" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="valordeStock">
                            Valor de Stock Mínimo
                        </label>
                        <input type="number" id="valordeStock" name="valordeStock" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="id_tipo_producto">
                            Tipo de Producto
                        </label>
                        <select id="id_tipo_producto" name="id_tipo_producto" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">Seleccione un tipo</option>
                            <?php
                            require_once '../modelo/conexion.php';
                            $db = new Conexion();
                            $conn = $db->getConexion();
                            $query = "SELECT id_tipo_producto, nombreTipo FROM tipo_producto";
                            $result = $conn->query($query);
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['id_tipo_producto'] . "'>" . htmlspecialchars($row['nombreTipo']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="Descripcion">
                            Descripción
                        </label>
                        <textarea id="Descripcion" name="Descripcion" rows="4" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2" for="foto">
                            Imagen del Producto
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div class="col-span-2 flex justify-end space-x-4">
                    <button type="reset"
                        class="px-6 py-2 border border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition-colors">
                        Limpiar
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Preview de imagen
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Aquí puedes agregar código para mostrar una vista previa de la imagen
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>