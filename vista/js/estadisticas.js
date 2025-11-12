/**
 * Módulo de Estadísticas del Dashboard
 * Gestiona la carga y visualización de estadísticas de productos
 */

/**
 * Cargar estadísticas desde el servidor
 * @async
 */
async function cargarEstadisticas() {
    try {
        const response = await fetch('../Controlador/listar-productos.php');
        if (!response.ok) {
            throw new Error(`Error en la respuesta: ${response.status}`);
        }
        const productos = await response.json();

        // Calcular estadísticas
        const stats = calcularEstadisticas(productos);
        
        // Actualizar UI
        actualizarEstadisticasUI(stats);

    } catch (error) {
        console.error('Error al cargar estadísticas:', error);
        mostrarErrorEstadisticas();
    }
}

/**
 * Calcular estadísticas a partir de los productos
 * @param {Array} productos - Array de objetos producto
 * @returns {Object} Objeto con estadísticas calculadas
 */
function calcularEstadisticas(productos) {
    const totalProductos = productos.length;
    const valorTotal = productos.reduce((sum, p) => {
        const precio = parseFloat(p.Precio) || 0;
        const cantidad = parseInt(p.cantidad) || 0;
        return sum + (precio * cantidad);
    }, 0);

    const stockBajo = productos.filter(p => {
        const cantidad = parseInt(p.cantidad) || 0;
        const minimo = parseInt(p.valordeStock) || 0;
        return cantidad <= minimo;
    }).length;

    // Obtener categorías únicas
    const categorias = new Set(productos.map(p => p.nombreTipo || 'Sin categoría')).size;

    return {
        totalProductos,
        valorTotal,
        stockBajo,
        categorias,
        productosDisponibles: productos.filter(p => parseInt(p.cantidad) > 0).length
    };
}

/**
 * Actualizar los elementos del UI con las estadísticas
 * @param {Object} stats - Objeto con estadísticas
 */
function actualizarEstadisticasUI(stats) {
    // Actualizar total de productos
    const totalElement = document.getElementById('total-productos');
    if (totalElement) {
        totalElement.textContent = stats.totalProductos;
    }

    // Actualizar valor total
    const valorElement = document.getElementById('valor-total');
    if (valorElement) {
        valorElement.textContent = '$' + stats.valorTotal.toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    // Actualizar stock bajo
    const stockElement = document.getElementById('stock-bajo');
    if (stockElement) {
        stockElement.textContent = stats.stockBajo;
    }

    // Actualizar categorías
    const categoriasElement = document.getElementById('total-categorias');
    if (categoriasElement) {
        categoriasElement.textContent = stats.categorias;
    }

    // Actualizar productos disponibles (si existe el elemento)
    const disponiblesElement = document.getElementById('productos-disponibles');
    if (disponiblesElement) {
        disponiblesElement.textContent = stats.productosDisponibles;
    }
}

/**
 * Mostrar mensaje de error en las estadísticas
 */
function mostrarErrorEstadisticas() {
    document.getElementById('total-productos').textContent = '—';
    document.getElementById('valor-total').textContent = '$—';
    document.getElementById('stock-bajo').textContent = '—';
    document.getElementById('total-categorias').textContent = '—';
}

/**
 * Inicializar el módulo (llamar en DOMContentLoaded)
 */
function inicializarEstadisticas() {
    cargarEstadisticas();
    // Recargar cada 30 segundos (opcional)
    // setInterval(cargarEstadisticas, 30000);
}

// Exportar para uso global (si lo necesitas en otros scripts)
window.estadisticas = {
    cargar: cargarEstadisticas,
    inicializar: inicializarEstadisticas
};
