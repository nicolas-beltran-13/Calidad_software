<?php
// Incluye verificación de sesión y rol admin
include_once '../Controlador/verificar_admin.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - DondePepito</title>
     <script src="https://cdn.tailwindcss.com" ></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B1F1F',
                        secondary: '#5C1414',
                        accent: '#D4AF37',
                        background: '#F9F9F9',
                        surface: '#FFFFFF',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background">
    <!-- Barra lateral -->
    <div id="sidebar"
        class="fixed left-0 top-0 h-screen w-64 bg-primary text-white shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        <div class="p-6 border-b border-secondary">
            <div class="flex items-center space-x-3">
                <i class="fas fa-store text-2xl"></i>
                <span class="text-xl font-bold">DondePepito</span>
            </div>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="dashboard.php"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary">
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
                    <a href="reportes.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a href="../Controlador/logout.php"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Overlay para móvil -->
    <!-- Overlay para móvil -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden z-40"
     role="button" tabindex="0" aria-label="Cerrar barra lateral" 
     onclick="toggleSidebar()" 
     onKeyDown="if(event.key === 'Enter' || event.key === ' ') { toggleSidebar(); }">
</div>


    <!-- Modal de confirmación de eliminación -->
    <div id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-sm text-gray-500" id="delete-message">
                    ¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="cancel-delete"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button id="confirm-delete"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="md:ml-64 p-4 md:p-8">
        <!-- Header -->
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <button id="menu-btn"
                    class="md:hidden bg-primary text-white p-2 rounded-lg hover:bg-secondary transition-colors"
                    onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Gestión de Productos</h1>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Lista de productos -->
        <div class="bg-surface p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Productos Registrados</h2>
            <div id="productos-lista" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Los productos se cargarán aquí dinámicamente -->
            </div>
        </div>

        <!-- Formulario de producto -->
        <div class="bg-surface p-8 rounded-xl shadow-xl border border-gray-100">
            <div class="flex items-center mb-8">
                <div class="bg-primary rounded-full p-3 mr-4">
                    <i class="fas fa-plus text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Agregar Nuevo Producto</h2>
                    <p class="text-gray-600">Complete todos los campos para registrar un nuevo producto</p>
                </div>
            </div>

            <form action="../Controlador/agregar-producto.php" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                <!-- Información Básica -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Información Básica
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="nombreProducto">
                                <i class="fas fa-tag text-primary mr-1"></i>Nombre del Producto *
                            </label>
                            <input type="text" id="nombreProducto" name="nombreProducto" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Ej: Queso Fresco">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="id_tipo_producto">
                                <i class="fas fa-list text-primary mr-1"></i>Tipo de Producto *
                            </label>
                            <select id="id_tipo_producto" name="id_tipo_producto" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <option value="">Seleccione un tipo</option>
                                <?php
                                    require_once '../modelo/tipoProductoModelo.php';
                                    $tipos = obtenerTiposProducto();
                                    while($row = $tipos->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="'. htmlspecialchars($row['id_tipo_producto']) .'">'. htmlspecialchars($row['nombreTipo']) .'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Información de Inventario -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-warehouse text-primary mr-2"></i>
                        Información de Inventario
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="Precio">
                                <i class="fas fa-dollar-sign text-primary mr-1"></i>Precio *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">$</span>
                                <input type="number" id="Precio" name="Precio" step="0.01" required
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="cantidad">
                                <i class="fas fa-boxes text-primary mr-1"></i>Cantidad en Stock *
                            </label>
                            <input type="number" id="cantidad" name="cantidad" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="valordeStock">
                                <i class="fas fa-exclamation-triangle text-primary mr-1"></i>Stock Mínimo *
                            </label>
                            <input type="number" id="valordeStock" name="valordeStock" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Descripción y Imagen -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-primary mr-2"></i>
                        Descripción y Multimedia
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="Descripcion">
                                <i class="fas fa-align-left text-primary mr-1"></i>Descripción *
                            </label>
                            <textarea id="Descripcion" name="Descripcion" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-vertical"
                                placeholder="Describe las características del producto..."></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="foto">
                                <i class="fas fa-camera text-primary mr-1"></i>Imagen del Producto *
                            </label>
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                                <input type="file" id="foto" name="foto" accept="image/*" required
                                    class="hidden" onchange="previewImage(this)">
                                <label for="foto" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Haz clic para seleccionar una imagen</p>
                                    <p class="text-sm text-gray-500">PNG, JPG hasta 5MB</p>
                                </label>
                            </div>
                            <div id="image-preview" class="mt-4 hidden">
                                <img id="preview-img" src="" alt="Vista previa"
                                    class="w-full h-32 object-cover rounded-lg border">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div
                    class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                    <button type="reset"
                        class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all font-medium">
                        <i class="fas fa-eraser mr-2"></i>Limpiar Formulario
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition-all font-medium shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/productos.js"></script>

</body>
</html>