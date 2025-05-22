// Funcions per gestionar el carret de compra
let cartItems = [];

// Carregar els elements del carret
function loadCartItems() {
    fetch('carret.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get'
    })
    .then(response => response.json())
    .then(data => {
        cartItems = data.items || [];
        updateCartDisplay();
    })
    .catch(error => console.error('Error:', error));
}

// Actualitzar la visualització del carret
function updateCartDisplay() {
    const cartContainer = document.querySelector('.cart-items');
    if (!cartContainer) return;

    cartContainer.innerHTML = '';
    let total = 0;

    cartItems.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <span class="item-name">${item.name}</span>
            <span class="item-price">${item.price}€</span>
            <button onclick="removeFromCart(${item.id})" class="remove-btn">Eliminar</button>
        `;
        cartContainer.appendChild(itemElement);
        total += parseFloat(item.price);
    });

    // Actualitzar el total
    const totalElement = document.querySelector('.cart-total');
    if (totalElement) {
        totalElement.textContent = `Total: ${total.toFixed(2)}€`;
    }

    // Actualitzar el comptador
    updateCartCounter(cartItems.length);
}

// Eliminar un producte del carret
function removeFromCart(id) {
    fetch('carret.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=remove&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualitzar el comptador del carret
            const counter = document.querySelector('.contador-carret');
            if (counter) {
                counter.textContent = data.count;
            }
            
            // Eliminar l'element del DOM
            const itemToRemove = document.querySelector(`.cart-item[data-id="${id}"]`);
            if (itemToRemove) {
                itemToRemove.remove();
                
                // Actualitzar el total
                const total = Array.from(document.querySelectorAll('.cart-item'))
                    .reduce((sum, item) => {
                        const subtotalText = item.querySelector('.subtotal').textContent;
                        const subtotal = parseFloat(subtotalText.replace('Subtotal: ', '').replace('€', ''));
                        return sum + subtotal;
                    }, 0);
                
                const totalElement = document.querySelector('.cart-total h3');
                if (totalElement) {
                    totalElement.textContent = `Total: ${total.toFixed(2)}€`;
                }
                
                // Si no hi ha més elements, mostrar missatge de carret buit
                if (document.querySelectorAll('.cart-item').length === 0) {
                    const cartSection = document.querySelector('.seccio_carret .caixa');
                    if (cartSection) {
                        cartSection.innerHTML = `
                            <h1>El teu carret</h1>
                            <p>El teu carret està buit.</p>
                            <a href="botiga.php" class="boto-tornar">Torna a la botiga</a>
                        `;
                    }
                }
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Actualitzar el comptador del carret
function updateCartCounter(count) {
    const counter = document.querySelector('.contador-carret');
    if (counter) {
        counter.textContent = count;
    }
}

// Carregar els elements del carret quan es carrega la pàgina
document.addEventListener('DOMContentLoaded', loadCartItems);