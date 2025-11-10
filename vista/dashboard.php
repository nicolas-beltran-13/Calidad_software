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
    <title>Dashboard - DondePepito</title>
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
    <div id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-primary text-white shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        <div class="p-6 border-b border-secondary">
            <div class="flex items-center space-x-3">
                <i class="fas fa-store text-2xl"></i>
                <span class="text-xl font-bold">DondePepito</span>
            </div>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="dashboard.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary">
                        <i class="fas fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
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
                    <a href="../Controlador/logout.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Overlay para móvil -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden z-40" onclick="toggleSidebar()"></div>

    <!-- Contenido principal -->
    <div class="md:ml-64 p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <button id="menu-btn" class="md:hidden bg-primary text-white p-2 rounded-lg hover:bg-secondary transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Dashboard Administrativo</h1>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-surface p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-blue-500 rounded-full p-3 mr-4">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Productos</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-productos">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-green-500 rounded-full p-3 mr-4">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Valor Total Inventario</p>
                        <p class="text-2xl font-bold text-gray-800" id="valor-total">$0</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-yellow-500 rounded-full p-3 mr-4">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Productos con Stock Bajo</p>
                        <p class="text-2xl font-bold text-gray-800" id="stock-bajo">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-purple-500 rounded-full p-3 mr-4">
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Categorías</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-categorias">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="admin-dashboard.php" class="bg-surface p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200 hover:border-primary">
                <div class="flex items-center mb-4">
                    <div class="bg-primary rounded-full p-3 mr-4">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Gestión de Productos</h3>
                        <p class="text-gray-600">Agregar, editar y eliminar productos</p>
                    </div>
                </div>
                <div class="text-primary font-medium">
                    <i class="fas fa-arrow-right mr-2"></i>Ir a Productos
                </div>
            </a>

            <a href="reportes.php" class="bg-surface p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200 hover:border-primary">
                <div class="flex items-center mb-4">
                    <div class="bg-primary rounded-full p-3 mr-4">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Reportes y Estadísticas</h3>
                        <p class="text-gray-600">Generar reportes detallados</p>
                    </div>
                </div>
                <div class="text-primary font-medium">
                    <i class="fas fa-arrow-right mr-2"></i>Ver Reportes
                </div>
            </a>

            <div class="bg-surface p-6 rounded-lg shadow-md border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="bg-gray-500 rounded-full p-3 mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Gestión de Usuarios</h3>
                        <p class="text-gray-600">Próximamente disponible</p>
                    </div>
                </div>
                <div class="text-gray-400 font-medium">
                    <i class="fas fa-clock mr-2"></i>En desarrollo
                </div>
            </div>
        </div>

        <!-- Actividad reciente -->
        <div class="bg-surface p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Actividad Reciente</h2>
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="bg-green-500 rounded-full p-2 mr-4">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Nuevo producto agregado</p>
                        <p class="text-gray-600 text-sm">Hace 2 horas</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="bg-blue-500 rounded-full p-2 mr-4">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Producto actualizado</p>
                        <p class="text-gray-600 text-sm">Hace 5 horas</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="bg-yellow-500 rounded-full p-2 mr-4">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Producto con stock bajo</p>
                        <p class="text-gray-600 text-sm">Hace 1 día</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Función para cargar estadísticas
    async function cargarEstadisticas() {
        try {
            const response = await fetch('../Controlador/listar-productos.php');
            const productos = await response.json();

            // Calcular estadísticas
            const totalProductos = productos.length;
            const valorTotal = productos.reduce((sum, p) => sum + (parseFloat(p.Precio) * parseInt(p.cantidad)), 0);
            const stockBajo = productos.filter(p => parseInt(p.cantidad) <= parseInt(p.valordeStock)).length;

            // Obtener categorías únicas
            const categorias = [...new Set(productos.map(p => p.nombreTipo))].length;

            // Actualizar UI
            document.getElementById('total-productos').textContent = totalProductos;
            document.getElementById('valor-total').textContent = '$' + valorTotal.toLocaleString();
            document.getElementById('stock-bajo').textContent = stockBajo;
            document.getElementById('total-categorias').textContent = categorias;

        } catch (error) {
            console.error('Error al cargar estadísticas:', error);
        }
    }

    // Función para alternar la barra lateral
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    // Cargar estadísticas al cargar la página
    document.addEventListener('DOMContentLoaded', cargarEstadisticas);
    </script>
</body>

</html>
