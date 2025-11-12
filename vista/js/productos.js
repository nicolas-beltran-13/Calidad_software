// Función para cargar productos
async function cargarProductos() {
    try {
        const response = await fetch('../Controlador/listar-productos.php');
        const productos = await response.json();
        mostrarProductos(productos);
    } catch (error) {
        console.error('Error al cargar productos:', error);
    }
}

// Función para mostrar productos
function mostrarProductos(productos) {
    const contenedor = document.getElementById('productos-lista');
    contenedor.innerHTML = '';

    if (productos.length === 0) {
        contenedor.innerHTML = '<p class="text-gray-500 text-center col-span-full">No hay productos registrados.</p>';
        return;
    }

    productos.forEach(producto => {
        const productoDiv = document.createElement('div');
        productoDiv.className = 'bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow';

        const imagenSrc = producto.foto ? `data:image/jpeg;base64,${producto.foto}` : 'https://via.placeholder.com/300x200?text=Sin+Imagen';

        productoDiv.innerHTML = `
            <div class="relative">
                <img src="${imagenSrc}" alt="${producto.nombreProducto}" class="w-full h-48 object-cover">
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg text-gray-800 mb-2">${producto.nombreProducto}</h3>
                <p class="text-sm text-gray-600 mb-2">${producto.Descripcion}</p>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-primary font-semibold">$${producto.Precio.toLocaleString()}</span>
                    <span class="text-sm text-gray-500">${producto.nombreTipo}</span>
                </div>
                <div class="text-sm text-gray-600 mb-4">
                    <p>Stock: ${producto.cantidad}</p>
                    <p>Stock Mínimo: ${producto.valordeStock}</p>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm" onclick="editarProducto(${producto.id_producto})">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="flex-1 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors text-sm" onclick="eliminarProducto(${producto.id_producto})">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        `;

        contenedor.appendChild(productoDiv);
    });
}

// Función para editar producto
function editarProducto(id) {
    window.location.href = `editar-producto.php?id=${id}`;
}

// Variable global para almacenar el ID del producto a eliminar
let productoAEliminar = null;

// Función para eliminar producto
function eliminarProducto(id) {
    productoAEliminar = id;
    const modal = document.getElementById('delete-modal');
    const message = document.getElementById('delete-message');
    message.textContent = '¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.';
    modal.classList.remove('hidden');
}

// Función para confirmar eliminación
function confirmarEliminacion() {
    if (productoAEliminar) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Controlador/eliminar-producto.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id_producto';
        input.value = productoAEliminar;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Función para cancelar eliminación
function cancelarEliminacion() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    productoAEliminar = null;
}

// Función para mostrar preview de imagen
function previewImage(input) {
    const file = input.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
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

// Event listeners para el modal
document.getElementById('cancel-delete').addEventListener('click', cancelarEliminacion);
document.getElementById('confirm-delete').addEventListener('click', confirmarEliminacion);

// Cerrar modal al hacer clic fuera
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        cancelarEliminacion();
    }
});

// Cargar productos al cargar la página
document.addEventListener('DOMContentLoaded', cargarProductos);