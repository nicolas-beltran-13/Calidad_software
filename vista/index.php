<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DondePepito - Tu tienda de confianza</title>

    <!-- Estilos y scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B1F1F', // Rojo guinda principal
                        secondary: '#5C1414', // Rojo guinda oscuro
                        accent: '#D4AF37', // Dorado elegante
                        background: '#F9F9F9', // Fondo claro
                        surface: '#FFFFFF', // Superficie blanca
                        cafe: '#8B4513', // Café para acentos
                        'cafe-light': '#A0522D', // Café claro
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-background font-poppins">
    <!-- Barra de navegación principal -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center h-auto md:h-16 py-4 md:py-0">
                <!-- Logo -->
                <div class="flex justify-center md:justify-start mb-4 md:mb-0">
                    <div class="flex items-center space-x-2 text-primary font-bold text-xl">
                        <i class="fas fa-store text-2xl"></i>
                        <span>DondePepito</span>
                    </div>
                </div>

                <!-- Barra de búsqueda -->
                <div class="w-full md:w-1/2 flex justify-center mb-4 md:mb-0">
                    <div class="w-full max-w-md">
                        <form>
                            <div class="relative">
                                <input type="text" id="search" name="search" placeholder="¿Qué estás buscando hoy?"
                                       class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" autocomplete="off">
                                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-primary text-white p-2 rounded-full hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Enlaces de navegación -->
                <div class="flex justify-center md:justify-end items-center space-x-4">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="../Controlador/logout.php" class="text-secondary hover:text-primary transition-colors">
                            <i class="fas fa-sign-out-alt text-xl"></i>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="text-secondary hover:text-primary transition-colors">
                            <i class="fas fa-user text-xl"></i>
                        </a>
                    <?php endif; ?>
                    <a href="#" id="cart-btn-header" class="relative text-secondary hover:text-primary transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Menú secundario -->
    <nav class="bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="flex flex-wrap justify-center items-center space-x-4 md:space-x-12 py-3">
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium text-sm md:text-lg">Ofertas del Día</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium text-sm md:text-lg">Más Vendidos</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium text-sm md:text-lg">Productos Frescos</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium text-sm md:text-lg">Novedades</a></li>
            </ul>
        </div>
    </nav>

    <!-- Banner principal -->
    <section class="bg-gradient-to-br from-primary via-cafe to-secondary text-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 text-shadow-lg">¡Bienvenidos a DondePepito!</h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 opacity-90">Tu tienda de confianza para productos frescos y de calidad</p>

            <!-- Temporizador -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 md:p-8 inline-block border border-accent/30">
                <h2 class="text-xl md:text-2xl font-semibold mb-6 text-accent">La Promo Termina en:</h2>
                <div class="flex flex-wrap justify-center space-x-2 md:space-x-4" id="countdown">
                    <div class="bg-accent/20 rounded-lg p-3 md:p-4 min-w-[70px] md:min-w-[80px] mb-2 md:mb-0 border border-accent/30">
                        <div class="text-2xl md:text-3xl font-bold hours text-accent">24</div>
                        <div class="text-xs md:text-sm opacity-80">Horas</div>
                    </div>
                    <div class="bg-accent/20 rounded-lg p-3 md:p-4 min-w-[70px] md:min-w-[80px] mb-2 md:mb-0 border border-accent/30">
                        <div class="text-2xl md:text-3xl font-bold minutes text-accent">00</div>
                        <div class="text-xs md:text-sm opacity-80">Minutos</div>
                    </div>
                    <div class="bg-accent/20 rounded-lg p-3 md:p-4 min-w-[70px] md:min-w-[80px] mb-2 md:mb-0 border border-accent/30">
                        <div class="text-2xl md:text-3xl font-bold seconds text-accent">00</div>
                        <div class="text-xs md:text-sm opacity-80">Segundos</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Modal -->
    <div id="cart-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-11/12 md:w-2/3 lg:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tu Carrito</h3>
                <button class="close-cart text-gray-600 hover:text-gray-900">Cerrar ✕</button>
            </div>
            <div id="cart-items" class="space-y-3 max-h-64 overflow-auto mb-4">
                
                <!-- carrito -->
            </div>
            <div class="flex justify-between items-center border-t pt-4">
                <div id="cart-total" class="font-semibold">Total: $0</div>
                <div class="flex gap-2">
                    <button id="checkout-btn" class="px-4 py-2 bg-primary text-white rounded">Pagar</button>
                    <button class="close-cart px-4 py-2 border rounded">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cupones de descuento -->
    <section class="py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-secondary mb-12">¡Cupones de Descuento!</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-cafe/10 to-accent/10 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$50.000</div>
                    <div class="text-secondary mb-4">sobre +$300.000</div>
                    <div class="bg-gradient-to-r from-primary to-cafe text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL50</div>
                </div>
                <div class="bg-gradient-to-br from-cafe/10 to-accent/10 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$30.000</div>
                    <div class="text-secondary mb-4">sobre +$200.000</div>
                    <div class="bg-gradient-to-r from-primary to-cafe text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL30</div>
                </div>
                <div class="bg-gradient-to-br from-cafe/10 to-accent/10 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$15.000</div>
                    <div class="text-secondary mb-4">sobre +$100.000</div>
                    <div class="bg-gradient-to-r from-primary to-cafe text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL15</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Beneficios -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-primary text-white p-4 rounded-full mb-4">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                    <span class="font-semibold text-secondary">Calidad Garantizada</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-primary text-white p-4 rounded-full mb-4">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <span class="font-semibold text-secondary">Servicio Rápido</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-primary text-white p-4 rounded-full mb-4">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <span class="font-semibold text-secondary">Productos 100% Frescos</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-primary text-white p-4 rounded-full mb-4">
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                    <span class="font-semibold text-secondary">Atención Personalizada</span>
                </div>
            </div>
        </div>
    </section>
                        
    <!-- Productos destacados -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-secondary mb-12">Productos Disponibles</h2>
            <div id="productos-destacados" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Los productos se cargarán dinámicamente aquí -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Atención al Cliente</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Centro de Ayuda</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Devoluciones</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Métodos de Pago</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Sobre Nosotros</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Quiénes Somos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nuestras Tiendas</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Trabaja con Nosotros</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors text-2xl">
                            <i class="fab fa-instagram"></i>
                        </a>    
                        <a href="#" class="text-gray-300 hover:text-white transition-colors text-2xl">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-300">&copy; 2025 DondePepito. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Carrito de compras
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Función para actualizar contador del carrito
        function updateCartCount() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
        }

        // Función para agregar al carrito
        function addToCart(productId, productName, productPrice) {
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1
                });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            showNotification(`${productName} agregado al carrito`);
        }

        // Función para mostrar notificación
        function showNotification(message) {
            // Crear elemento de notificación
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);

            // Remover después de 3 segundos
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Función para cargar productos
        async function cargarProductos() {
            try {
                const response = await fetch('../Controlador/productos-publicos.php');
                const productos = await response.json();
                mostrarProductos(productos);
            } catch (error) {
                console.error('Error al cargar productos:', error);
            }
        }

        // Función para mostrar productos
        function mostrarProductos(productos) {
            const contenedor = document.getElementById('productos-destacados');
            contenedor.innerHTML = '';

            if (productos.length === 0) {
                contenedor.innerHTML = '<p class="text-gray-500 text-center col-span-full">No hay productos disponibles.</p>';
                return;
            }

            productos.forEach(producto => {
                const productoDiv = document.createElement('div');
                productoDiv.className = 'bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow';

                const imagenSrc = producto.foto ? `data:image/jpeg;base64,${producto.foto}` : 'https://via.placeholder.com/300x200?text=Sin+Imagen';

                productoDiv.innerHTML = `
                    <div class="relative">
                        <img src="${imagenSrc}" alt="${producto.nombreProducto}" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">${producto.nombreProducto}</h3>
                        <p class="text-sm text-gray-600 mb-2">${producto.Descripcion}</p>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-primary font-semibold">$${producto.Precio.toLocaleString()}</span>
                            <span class="text-sm text-gray-500">${producto.nombreTipo}</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <p>Stock: ${producto.cantidad}</p>
                        </div>
                        <div class="mt-4">
                            <button class="add-to-cart-btn w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition-colors" data-id="${producto.id_producto}" data-name="${producto.nombreProducto}" data-price="${producto.Precio}">Agregar al carrito</button>
                        </div>
                    </div>
                `;

                contenedor.appendChild(productoDiv);
            });

            // Agregar event listeners a los botones
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.dataset.id);
                    const name = this.dataset.name;
                    const price = parseFloat(this.dataset.price);
                    addToCart(id, name, price);
                });
            });
        }

        // Modal del carrito
        const cartModal = document.getElementById('cart-modal');
        const cartBtn = document.getElementById('cart-btn-header');
        const closeCartBtns = document.querySelectorAll('.close-cart');

        cartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showCartModal();
        });

        closeCartBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                cartModal.classList.add('hidden');
            });
        });

        function showCartModal() {
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            cartItems.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500 text-center">Tu carrito está vacío</p>';
            } else {
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex justify-between items-center border-b pb-2';
                    itemDiv.innerHTML = `
                        <div>
                            <h4 class="font-semibold">${item.name}</h4>
                            <p class="text-sm text-gray-600">$${item.price.toLocaleString()} x ${item.quantity}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="update-quantity px-2 py-1 bg-gray-200 rounded" data-id="${item.id}" data-change="-1">-</button>
                            <span>${item.quantity}</span>
                            <button class="update-quantity px-2 py-1 bg-gray-200 rounded" data-id="${item.id}" data-change="1">+</button>
                            <button class="remove-item px-2 py-1 bg-red-500 text-white rounded ml-2" data-id="${item.id}">×</button>
                        </div>
                    `;
                    cartItems.appendChild(itemDiv);
                });
            }

            cartTotal.textContent = `Total: $${total.toLocaleString()}`;
            cartModal.classList.remove('hidden');

            // Event listeners para actualizar cantidad
            document.querySelectorAll('.update-quantity').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.dataset.id);
                    const change = parseInt(this.dataset.change);
                    updateCartQuantity(id, change);
                });
            });

            // Event listeners para remover items
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.dataset.id);
                    removeFromCart(id);
                });
            });
        }

        function updateCartQuantity(id, change) {
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(id);
                } else {
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    showCartModal();
                }
            }
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            showCartModal();
        }

        // Contador regresivo
        function updateCountdown() {
            const now = new Date();
            const end = new Date();
            end.setHours(30, 23, 59, 59);

            const diff = end - now;

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
            document.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
            document.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            cargarProductos();
            setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>
</body>
</html>
