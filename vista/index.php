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
                        primary: '#78abef',
                        secondary: '#1f2937', 
                        accent: '#f59e0b', 
                        background: '#f9fafb', 
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
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo (sin enlace) -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-2 text-primary font-bold text-xl">
                        <i class="fas fa-store text-2xl"></i>
                        <span>DondePepito</span>
                    </div>
                </div>

                <!-- Barra de búsqueda -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="¿Qué estás buscando hoy?"
                               class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <button class="absolute right-2 top-2 bg-primary text-white p-2 rounded-full hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Enlaces de navegación -->
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <span class="text-secondary">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</span>
                        <a href="../Controlador/logout.php" class="text-secondary hover:text-primary transition-colors">
                            <i class="fas fa-sign-out-alt text-xl"></i> Cerrar Sesión
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="text-secondary hover:text-primary transition-colors flex items-center space-x-1">
                            <i class="fas fa-user text-xl"></i>
                            <span>Iniciar Sesión</span>
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
            <ul class="flex space-x-8 py-3">
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium">Ofertas del Día</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium">Más Vendidos</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium">Productos Frescos</a></li>
                <li><a href="#" class="text-white hover:text-accent transition-colors font-medium">Novedades</a></li>
            </ul>
        </div>
    </nav>

    <!-- Banner principal -->
    <section class="bg-gradient-to-br from-primary via-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-shadow-lg">¡Bienvenidos a DondePepito!</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Tu tienda de confianza para productos frescos y de calidad</p>

            <!-- Temporizador -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 inline-block">
                <h2 class="text-2xl font-semibold mb-6">La Promo Termina en:</h2>
                <div class="flex space-x-4 justify-center" id="countdown">
                    <div class="bg-white/20 rounded-lg p-4 min-w-[80px]">
                        <div class="text-3xl font-bold hours">24</div>
                        <div class="text-sm opacity-80">Horas</div>
                    </div>
                    <div class="bg-white/20 rounded-lg p-4 min-w-[80px]">
                        <div class="text-3xl font-bold minutes">00</div>
                        <div class="text-sm opacity-80">Minutos</div>
                    </div>
                    <div class="bg-white/20 rounded-lg p-4 min-w-[80px]">
                        <div class="text-3xl font-bold seconds">00</div>
                        <div class="text-sm opacity-80">Segundos</div>
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
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-secondary mb-12">¡Cupones de Descuento!</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$50.000</div>
                    <div class="text-secondary mb-4">sobre +$300.000</div>
                    <div class="bg-primary text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL50</div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$30.000</div>
                    <div class="text-secondary mb-4">sobre +$200.000</div>
                    <div class="bg-primary text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL30</div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-primary rounded-2xl p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="text-4xl font-bold text-primary mb-2">-$15.000</div>
                    <div class="text-secondary mb-4">sobre +$100.000</div>
                    <div class="bg-primary text-white px-4 py-2 rounded-full inline-block font-semibold">Código: SAL15</div>
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
            <h2 class="text-3xl font-bold text-center text-secondary mb-12">Ofertas Destacadas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- 1 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/salchicha-perro-caliente.svg" alt="Salchicha Perro Caliente" class="w-full h-56 object-cover">
                        <div class="absolute top-4 left-4 bg-accent text-white px-3 py-1 rounded-full font-bold">Oferta</div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Salchicha Perro Caliente</h3>
                        <div class="text-primary font-semibold mb-2">$5.000</div>
                        <p class="text-sm text-gray-600">Salchicha americana para hot dogs, paquete 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="1" data-name="Salchicha Perro Caliente" data-price="5000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/jamon-cerdo-ahumado.svg" alt="Jamón de Cerdo Ahumado" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Jamón de Cerdo Ahumado</h3>
                        <div class="text-primary font-semibold mb-2">$35.000</div>
                        <p class="text-sm text-gray-600">Jamón de pernil de cerdo ahumado, 250g tajado.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="2" data-name="Jamón de Cerdo Ahumado" data-price="35000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 3 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/mortadela-pollo.svg" alt="Mortadela de Pollo" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Mortadela de Pollo</h3>
                        <div class="text-primary font-semibold mb-2">$6.800</div>
                        <p class="text-sm text-gray-600">Mortadela de pollo, presentación 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="3" data-name="Mortadela de Pollo" data-price="6800">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 4 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/chorizo-parrillero.svg" alt="Chorizo Parrillero" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Chorizo Parrillero</h3>
                        <div class="text-primary font-semibold mb-2">$45.000</div>
                        <p class="text-sm text-gray-600">Chorizo de cerdo para asar, pack 6 unidades.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="4" data-name="Chorizo Parrillero" data-price="45000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 5 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/salami-genova.svg" alt="Salami Tipo Génova" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Salami Tipo Génova</h3>
                        <div class="text-primary font-semibold mb-2">$20.000</div>
                        <p class="text-sm text-gray-600">Salami curado, 150g empacado al vacío.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="5" data-name="Salami Tipo Génova" data-price="20000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 6 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/queso-doble-crema.svg" alt="Queso Doble Crema" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Queso Doble Crema</h3>
                        <div class="text-primary font-semibold mb-2">$55.000</div>
                        <p class="text-sm text-gray-600">Queso fresco, suave, 250g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="6" data-name="Queso Doble Crema" data-price="55000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 7 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/queso-mozzarella-bloque.svg" alt="Queso Mozzarella Bloque" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Queso Mozzarella Bloque</h3>
                        <div class="text-primary font-semibold mb-2">$40.000</div>
                        <p class="text-sm text-gray-600">Queso semi-duro para gratinar, 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="7" data-name="Queso Mozzarella Bloque" data-price="40000">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 8 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/queso-parmesano-rallado.svg" alt="Queso Parmesano Rallado" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Queso Parmesano Rallado</h3>
                        <div class="text-primary font-semibold mb-2">$8.900</div>
                        <p class="text-sm text-gray-600">Queso maduro rallado, 100g bolsa.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="8" data-name="Queso Parmesano Rallado" data-price="8900">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 9 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/mantequilla-sin-sal.svg" alt="Mantequilla sin Sal" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Mantequilla sin Sal</h3>
                        <div class="text-primary font-semibold mb-2">$7.500</div>
                        <p class="text-sm text-gray-600">Mantequilla fresca sin sal, 250g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="9" data-name="Mantequilla sin Sal" data-price="7500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 10 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/yogurt-natural-entero.svg" alt="Yogurt Natural Entero" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Yogurt Natural Entero</h3>
                        <div class="text-primary font-semibold mb-2">$4.200</div>
                        <p class="text-sm text-gray-600">Yogurt sin azúcar, presentación 1L.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="10" data-name="Yogurt Natural Entero" data-price="4200">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 11 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/ketchup.svg" alt="Salsa de Tomate Ketchup" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Salsa de Tomate Ketchup</h3>
                        <div class="text-primary font-semibold mb-2">$5.100</div>
                        <p class="text-sm text-gray-600">Salsa de tomate clásica, botella 400g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="11" data-name="Salsa de Tomate Ketchup" data-price="5100">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 12 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/mayonesa.svg" alt="Mayonesa Clásica" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Mayonesa Clásica</h3>
                        <div class="text-primary font-semibold mb-2">$6.900</div>
                        <p class="text-sm text-gray-600">Aderezo a base de huevo y aceite, 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="12" data-name="Mayonesa Clásica" data-price="6900">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 13 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/mostaza-americana.svg" alt="Mostaza Americana" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Mostaza Americana</h3>
                        <div class="text-primary font-semibold mb-2">$4.800</div>
                        <p class="text-sm text-gray-600">Mostaza suave, frasco 250g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="13" data-name="Mostaza Americana" data-price="4800">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 14 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/salsa-bbq.svg" alt="Salsa BBQ Ahumada" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Salsa BBQ Ahumada</h3>
                        <div class="text-primary font-semibold mb-2">$9.500</div>
                        <p class="text-sm text-gray-600">Salsa para carnes a la parrilla, 370g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="14" data-name="Salsa BBQ Ahumada" data-price="9500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 15 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/aderezo-ranch.svg" alt="Aderezo Ranch" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Aderezo Ranch</h3>
                        <div class="text-primary font-semibold mb-2">$7.200</div>
                        <p class="text-sm text-gray-600">Aderezo cremoso para ensaladas, 300g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="15" data-name="Aderezo Ranch" data-price="7200">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 16 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/harina-trigo.svg" alt="Harina de Trigo" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Harina de Trigo Todo Uso</h3>
                        <div class="text-primary font-semibold mb-2">$3.500</div>
                        <p class="text-sm text-gray-600">Harina para múltiples preparaciones, 1000g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="16" data-name="Harina de Trigo Todo Uso" data-price="3500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 17 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/polvo-hornear.svg" alt="Polvo de Hornear" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Polvo de Hornear</h3>
                        <div class="text-primary font-semibold mb-2">$2.100</div>
                        <p class="text-sm text-gray-600">Leudante químico para repostería, 100g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="17" data-name="Polvo de Hornear" data-price="2100">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 18 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/azucar-impalpable.svg" alt="Azúcar Impalpable" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Azúcar Impalpable</h3>
                        <div class="text-primary font-semibold mb-2">$4.500</div>
                        <p class="text-sm text-gray-600">Azúcar muy fina para decoración, 200g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="18" data-name="Azúcar Impalpable" data-price="4500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 19 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/levadura-fresca.svg" alt="Levadura Fresca" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Levadura Fresca</h3>
                        <div class="text-primary font-semibold mb-2">$1.500</div>
                        <p class="text-sm text-gray-600">Levadura para panificación, sobre 50g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="19" data-name="Levadura Fresca" data-price="1500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 20 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/esencia-vainilla.svg" alt="Esencia de Vainilla" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Esencia de Vainilla</h3>
                        <div class="text-primary font-semibold mb-2">$3.800</div>
                        <p class="text-sm text-gray-600">Saborizante líquido, presentación 120ml.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="20" data-name="Esencia de Vainilla" data-price="3800">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 21 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/frijoles-rojos-secos.svg" alt="Frijoles Rojos Secos" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Frijoles Rojos Secos</h3>
                        <div class="text-primary font-semibold mb-2">$5.500</div>
                        <p class="text-sm text-gray-600">Frijoles para cocción, paquete 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="21" data-name="Frijoles Rojos Secos" data-price="5500">Agregar al carrito</button>
                        </div>
                    </div>
                </div>

                <!-- 22 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img src="img/lentejas-secas.svg" alt="Lentejas Secas" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-secondary mb-2">Lentejas Secas</h3>
                        <div class="text-primary font-semibold mb-2">$4.900</div>
                        <p class="text-sm text-gray-600">Lentejas para guisos, paquete 500g.</p>
                        <div class="mt-4">
                            <button class="add-to-cart px-4 py-2 bg-primary text-white rounded-lg" data-id="22" data-name="Lentejas Secas" data-price="4900">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
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
        // Contador regresivo
        function updateCountdown() {
            const now = new Date();
            const end = new Date();
            end.setHours(10,23, 59, 59);
            
            const diff = end - now;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
            document.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
            document.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>