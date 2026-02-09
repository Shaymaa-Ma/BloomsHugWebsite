let cart = JSON.parse(localStorage.getItem('cart')) || [];

const saveCart = () => localStorage.setItem('cart', JSON.stringify(cart));

const updateCartCount = () => {
    const count = document.getElementById('cartCount');
    if (count) {
        count.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
    }
};

const addToCart = (name, price, image) => {
    const item = cart.find(i => i.name === name);
    if (item) {
        item.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }
    saveCart();
    updateCartCount();
    alert(`${name} added to cart!`);
};

const updateCartDisplay = () => {
    const container = document.getElementById('cartItems');
    const totalEl = document.getElementById('totalAmount');
    const emptyMsg = document.getElementById('emptyCart');

    if (!container || !totalEl || !emptyMsg) return;

    container.innerHTML = "";
    if (cart.length === 0) {
        emptyMsg.style.display = 'block';
        totalEl.textContent = "Total: $0.00";
        return;
    }

    emptyMsg.style.display = 'none';
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;

        container.innerHTML += `
            <div class="row border-bottom py-3">
                <div class="col-3"><img src="${item.image}" class="img-fluid rounded" alt="${item.name}"></div>
                <div class="col-6">
                    <h5>${item.name}</h5>
                    <p>$${item.price.toFixed(2)}</p>
                </div>
                <div class="col-3 d-flex justify-content-between align-items-center">
                    <input type="number" value="${item.quantity}" min="1" class="form-control" 
                        onchange="updateQuantity('${item.name}', this.value)" style="width: 70px;">
                    <button class="btn btn-danger btn-sm ml-2" onclick="removeItem('${item.name}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>`;
    });

    totalEl.textContent = `Total: $${total.toFixed(2)}`;
};

const updateQuantity = (name, qty) => {
    const item = cart.find(i => i.name === name);
    if (item) {
        item.quantity = Math.max(1, parseInt(qty) || 1);
        saveCart();
        updateCartDisplay();
        updateCartCount();
    }
};

const removeItem = name => {
    cart = cart.filter(i => i.name !== name);
    saveCart();
    updateCartDisplay();
    updateCartCount();
};

const checkout = () => {
    if (cart.length === 0) {
        alert("Your cart is already empty.");
        return;
    }

    // Proceed to checkout form
    window.location.href = "checkout.html";
};

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    updateCartDisplay();
});
