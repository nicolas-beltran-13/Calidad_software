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
    <title>Reportes - DondePepito</title>
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
                    <a href="dashboard.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary transition-colors">
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
                    <a href="reportes.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary">
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
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden z-40"
     role="button" tabindex="0" aria-label="Cerrar barra lateral" 
     onclick="toggleSidebar()" 
     onKeyDown="if(event.key === 'Enter' || event.key === ' ') { toggleSidebar(); }">
</div>

    <!-- Contenido principal -->
    <div class="md:ml-64 p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <button id="menu-btn" class="md:hidden bg-primary text-white p-2 rounded-lg hover:bg-secondary transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Reportes y Estadísticas</h1>
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

        <!-- Reportes disponibles -->
        <div class="bg-surface p-8 rounded-xl shadow-xl border border-gray-100">
            <div class="flex items-center mb-8">
                <div class="bg-primary rounded-full p-3 mr-4">
                    <i class="fas fa-file-excel text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Generar Reportes</h2>
                    <p class="text-gray-600">Descarga reportes en formato Excel con la información de tus productos</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Reporte de Productos -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:border-primary transition-colors">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-500 rounded-full p-2 mr-3">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Reporte de Productos</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Lista completa de todos los productos registrados con sus detalles.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li>• ID del producto</li>
                        <li>• Nombre y tipo</li>
                        <li>• Precio y descripción</li>
                        <li>• Cantidad en stock</li>
                        <li>• Stock mínimo</li>
                    </ul>
                    <a href="../Controlador/generar-reporte.php"
                       class="w-full bg-primary text-white px-4 py-3 rounded-lg hover:bg-secondary transition-colors font-medium text-center block">
                        <i class="fas fa-file-excel mr-2"></i>Descargar Excel
                    </a>
                </div>

                <!-- Reporte de Inventario -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:border-primary transition-colors">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-500 rounded-full p-2 mr-3">
                            <i class="fas fa-warehouse text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Estado del Inventario</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Productos con stock bajo y análisis de inventario.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li>• Productos con stock bajo</li>
                        <li>• Valor total del inventario</li>
                        <li>• Alertas de reposición</li>
                        <li>• Análisis por categoría</li>
                    </ul>
                    <button onclick="generarReporteInventario()"
                            class="w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="fas fa-chart-line mr-2"></i>Generar Reporte
                    </button>
                </div>

                <!-- Reporte de Categorías -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:border-primary transition-colors">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-500 rounded-full p-2 mr-3">
                            <i class="fas fa-tags text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Análisis por Categoría</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Distribución de productos por tipo y categoría.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li>• Productos por categoría</li>
                        <li>• Valor por categoría</li>
                        <li>• Estadísticas detalladas</li>
                        <li>• Comparativas</li>
                    </ul>
                    <button onclick="generarReporteCategorias()"
                            class="w-full bg-purple-500 text-white px-4 py-3 rounded-lg hover:bg-purple-600 transition-colors font-medium">
                        <i class="fas fa-pie-chart mr-2"></i>Generar Reporte
                    </button>
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

    // Función para generar reporte de inventario
    function generarReporteInventario() {
        // Crear CSV con productos de stock bajo
        fetch('../Controlador/listar-productos.php')
            .then(response => response.json())
            .then(productos => {
                const stockBajo = productos.filter(p => parseInt(p.cantidad) <= parseInt(p.valordeStock));

                if (stockBajo.length === 0) {
                    alert('No hay productos con stock bajo actualmente.');
                    return;
                }

                // Crear y descargar CSV
                let csv = 'ID Producto,Nombre Producto,Tipo Producto,Precio,Cantidad Actual,Stock Mínimo,Diferencia\n';
                stockBajo.forEach(p => {
                    csv += `${p.id_producto},"${p.nombreProducto}","${p.nombreTipo}",${p.Precio},${p.cantidad},${p.valordeStock},${p.cantidad - p.valordeStock}\n`;
                });

                descargarCSV(csv, 'reporte_stock_bajo_' + new Date().toISOString().split('T')[0] + '.csv');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al generar el reporte');
            });
    }

    // Función para generar reporte de categorías
    function generarReporteCategorias() {
        fetch('../Controlador/listar-productos.php')
            .then(response => response.json())
            .then(productos => {
                // Agrupar por categoría
                const categorias = {};
                productos.forEach(p => {
                    if (!categorias[p.nombreTipo]) {
                        categorias[p.nombreTipo] = {
                            productos: [],
                            totalValor: 0,
                            totalCantidad: 0
                        };
                    }
                    categorias[p.nombreTipo].productos.push(p);
                    categorias[p.nombreTipo].totalValor += parseFloat(p.Precio) * parseInt(p.cantidad);
                    categorias[p.nombreTipo].totalCantidad += parseInt(p.cantidad);
                });

                // Crear CSV
                let csv = 'Categoría,Cantidad Productos,Valor Total,Cantidad Total\n';
                Object.keys(categorias).forEach(cat => {
                    csv += `"${cat}",${categorias[cat].productos.length},${categorias[cat].totalValor.toFixed(2)},${categorias[cat].totalCantidad}\n`;
                });

                descargarCSV(csv, 'reporte_categorias_' + new Date().toISOString().split('T')[0] + '.csv');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al generar el reporte');
            });
    }

    // Función auxiliar para descargar CSV
    function descargarCSV(csv, filename) {
        const blob = new Blob([new Uint8Array([0xEF, 0xBB, 0xBF]), csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
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
