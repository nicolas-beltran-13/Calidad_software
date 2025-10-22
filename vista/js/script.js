// Consolidated JavaScript para la Salsamentaria
// Maneja: detalles de producto, modales (login/registro), contacto y un carrito compatible

// Formatea precios (espera números enteros, sin decimales)
function formatPrice(value) {
    return '$' + Number(value).toLocaleString('es-CL');
}

// Cart storage key
const CART_KEY = 'cart';

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch (e) {
        console.error('Error parsing cart', e);
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function updateCartCount() {
    const cart = getCart();
    const totalQty = cart.reduce((s, i) => s + (i.qty || i.quantity || 0), 0);
    const counter = document.getElementById('cart-count');
    const cartBtn = document.getElementById('cart-btn');
    if (counter) counter.textContent = totalQty;
    if (cartBtn) cartBtn.textContent = `🛒 Carrito (${totalQty})`;
}

function addToCart(id, name, price) {
    const cart = getCart();
    const item = cart.find(i => String(i.id) === String(id));
    if (item) {
        item.qty = (item.qty || item.quantity || 0) + 1;
    } else {
        cart.push({ id: String(id), name: String(name), price: Number(price), qty: 1 });
    }
    saveCart(cart);
    updateCartCount();
}

function removeFromCart(id) {
    let cart = getCart();
    cart = cart.filter(i => String(i.id) !== String(id));
    saveCart(cart);
    updateCartCount();
    renderCartItems();
}

// Exponer para compatibilidad con llamadas inline antiguas
window.removeFromCart = removeFromCart;

function renderCartItems() {
    const container = document.getElementById('cart-items');
    const totalEl = document.getElementById('cart-total');
    if (!container || !totalEl) return;
    const cart = getCart();
    container.innerHTML = '';
    if (cart.length === 0) {
        container.innerHTML = '<div class="text-gray-600">Tu carrito está vacío.</div>';
        totalEl.textContent = 'Total: $0';
        return;
    }
    let total = 0;
    cart.forEach(item => {
        total += item.price * (item.qty || item.quantity || 0);
        const row = document.createElement('div');
        row.className = 'flex items-center justify-between gap-3';
        row.innerHTML = `
            <div class="flex-grow">
                <div class="font-medium">${item.name}</div>
                <div class="text-sm text-gray-600">${formatPrice(item.price)} x ${item.qty}</div>
            </div>
            <div class="flex items-center gap-2">
                <button class="decrease text-sm px-2 py-1 border rounded" data-id="${item.id}">-</button>
                <button class="increase text-sm px-2 py-1 border rounded" data-id="${item.id}">+</button>
                <button class="remove text-sm px-2 py-1 text-red-600" data-id="${item.id}">Eliminar</button>
            </div>
        `;
        container.appendChild(row);
    });
    totalEl.textContent = 'Total: ' + formatPrice(total);

    // attach events
    container.querySelectorAll('button.increase').forEach(b => b.addEventListener('click', () => {
        const id = b.dataset.id;
        const cart = getCart();
        const it = cart.find(x => String(x.id) === String(id));
        if (it) { it.qty = (it.qty || it.quantity || 0) + 1; saveCart(cart); renderCartItems(); updateCartCount(); }
    }));
    container.querySelectorAll('button.decrease').forEach(b => b.addEventListener('click', () => {
        const id = b.dataset.id;
        const cart = getCart();
        const it = cart.find(x => String(x.id) === String(id));
        if (it) { it.qty = Math.max(1, (it.qty || it.quantity || 0) - 1); saveCart(cart); renderCartItems(); updateCartCount(); }
    }));
    container.querySelectorAll('button.remove').forEach(b => b.addEventListener('click', () => {
        removeFromCart(b.dataset.id);
    }));
}

function openCartModal() {
    const modal = document.getElementById('cart-modal');
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    renderCartItems();
}

function closeCartModal() {
    const modal = document.getElementById('cart-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Detalles de producto
    document.querySelectorAll('.detalles-btn').forEach(btn => btn.addEventListener('click', function() {
        const producto = this.closest('[data-id]') || this.parentElement;
        const id = producto ? producto.dataset.id : null;
        const nombreEl = producto ? producto.querySelector('h3') : null;
        const nombre = nombreEl ? nombreEl.textContent : 'Producto';
        const precioEl = producto ? producto.querySelector('p') : null;
        const precio = precioEl ? precioEl.textContent : '';
        alert(`Producto: ${nombre}\nPrecio: ${precio}\nID: ${id}\n\n¡Gracias por tu interés!`);
    }));

    // Modales login/registro (si existen)
    const loginBtn = document.getElementById('login-btn');
    const registerBtn = document.getElementById('register-btn');
    const loginModal = document.getElementById('login-modal');
    const registerModal = document.getElementById('register-modal');
    document.querySelectorAll('.close').forEach(b => b.addEventListener('click', () => { if (loginModal) loginModal.style.display='none'; if (registerModal) registerModal.style.display='none'; closeCartModal(); }));
    window.addEventListener('click', (ev) => { if (ev.target === loginModal) loginModal.style.display='none'; if (ev.target === registerModal) registerModal.style.display='none'; });
    if (loginBtn && loginModal) loginBtn.addEventListener('click', () => loginModal.style.display = 'block');
    if (registerBtn && registerModal) registerBtn.addEventListener('click', () => registerModal.style.display = 'block');

    // Login form
    const loginForm = document.getElementById('login-form');
    if (loginForm) loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const user = users.find(u => u.email === email && u.password === password);
        if (user) { alert('¡Inicio de sesión exitoso!'); if (loginModal) loginModal.style.display='none'; } else { alert('Correo o contraseña incorrectos.'); }
    });

    // Register form
    const registerForm = document.getElementById('register-form');
    if (registerForm) registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const idType = document.getElementById('id-type').value;
        const idNumber = document.getElementById('id-number').value;
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const address = document.getElementById('address').value;
        const phone = document.getElementById('phone').value;
        const users = JSON.parse(localStorage.getItem('users')) || [];
        if (users.find(u => u.email === email)) { alert('El correo ya está registrado.'); return; }
        users.push({ idType, idNumber, name, email, password, address, phone });
        localStorage.setItem('users', JSON.stringify(users));
        alert('¡Registro exitoso!'); if (registerModal) registerModal.style.display='none';
    });

    // Contact form
    const contactForm = document.getElementById('contact-form');
    if (contactForm) contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('contact-name').value;
        alert(`¡Gracias ${name}! Tu mensaje ha sido enviado. Te contactaremos pronto.`);
        this.reset();
    });

    // Cart wiring: support buttons with class .add-to-cart and legacy .add-to-cart-btn
    document.querySelectorAll('.add-to-cart, .add-to-cart-btn').forEach(btn => btn.addEventListener('click', function() {
        const id = this.dataset.id || this.getAttribute('data-id');
        const name = this.dataset.name || this.getAttribute('data-name') || 'Producto';
        const price = this.dataset.price || this.getAttribute('data-price') || 0;
        addToCart(id, name, Number(price));
        // optional small feedback
        if (this.classList) this.classList.add('added');
    }));

    // Cart open button
    const cartBtn = document.getElementById('cart-btn') || document.querySelector('.open-cart');
    if (cartBtn) cartBtn.addEventListener('click', () => { openCartModal(); });

    // modal close for our cart modal
    document.querySelectorAll('#cart-modal .close-cart').forEach(b => b.addEventListener('click', closeCartModal));

    // Checkout
    const checkout = document.getElementById('checkout-btn');
    if (checkout) checkout.addEventListener('click', () => {
        const cart = getCart();
        if (cart.length === 0) { alert('El carrito está vacío.'); return; }
        // Demo: clear cart
        localStorage.removeItem(CART_KEY);
        updateCartCount();
        renderCartItems();
        closeCartModal();
        alert('Gracias por tu compra (simulada).');
    });

    // initialize
    updateCartCount();
});

