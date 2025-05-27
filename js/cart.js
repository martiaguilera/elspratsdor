// Arxiu principal per gestionar la funcionalitat del carret de compra

// Array per emmagatzemar els productes del carret en memòria
let cartItems = [];

// Funció per carregar els elements del carret des del servidor
function loadCartItems() {
    // Fem una petició POST al servidor per obtenir els productes del carret
    fetch('carret.php', {
        method: 'POST', // Utilitzem el mètode POST per seguretat
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Format de les dades enviades
        },
        body: 'action=get' // Acció per obtenir els productes
    })
    .then(response => response.json()) // Convertim la resposta a JSON
    .then(data => {
        cartItems = data.items || []; // Guardem els productes o un array buit si no n'hi ha
        updateCartDisplay(); // Actualitzem la visualització del carret
    })
    .catch(error => console.error('Error:', error)); // Capturem i mostrem qualsevol error
}

// Funció per actualitzar la visualització del carret a la interfície
function updateCartDisplay() {
    // Obtenim el contenidor dels productes del carret
    const cartContainer = document.querySelector('.cart-items');
    if (!cartContainer) return; // Si no existeix el contenidor, sortim

    // Netejem el contingut actual del carret
    cartContainer.innerHTML = '';
    let total = 0;

    // Iterem per cada producte i creem els elements HTML corresponents
    cartItems.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        // Creem l'estructura HTML per cada producte
        itemElement.innerHTML = `
            <span class="item-name">${item.name}</span>
            <span class="item-price">${item.price}€</span>
            <button onclick="removeFromCart(${item.id})" class="remove-btn">Eliminar</button>
        `;
        cartContainer.appendChild(itemElement); // Afegim el producte al contenidor
        total += parseFloat(item.price); // Sumem el preu al total
    });

    // Actualitzem l'element que mostra el total
    const totalElement = document.querySelector('.cart-total');
    if (totalElement) {
        totalElement.textContent = `Total: ${total.toFixed(2)}€`; // Formatem el total amb 2 decimals
    }

    // Actualitzem el comptador de productes
    updateCartCounter(cartItems.length);
}

// Funció per eliminar un producte específic del carret
function removeFromCart(id) {
    // Fem una petició POST al servidor per eliminar el producte
    fetch('carret.php', {
        method: 'POST', // Utilitzem el mètode POST per modificar dades
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Format de les dades
        },
        body: `action=remove&id=${id}` // Enviem l'acció i l'ID del producte a eliminar
    })
    .then(response => response.json()) // Convertim la resposta a JSON
    .then(data => {
        if (data.success) { // Si l'eliminació ha estat exitosa
            // Actualitzem el comptador del carret amb el nou número d'articles
            const counter = document.querySelector('.contador-carret');
            if (counter) {
                counter.textContent = data.count;
            }
            
            // Busquem i eliminem l'element del producte del DOM
            const itemToRemove = document.querySelector(`.cart-item[data-id="${id}"]`);
            if (itemToRemove) {
                itemToRemove.remove(); // Eliminem l'element de la pàgina
                
                // Recalculem el total sumant els subtotals dels productes restants
                const total = Array.from(document.querySelectorAll('.cart-item'))
                    .reduce((sum, item) => {
                        const subtotalText = item.querySelector('.subtotal').textContent;
                        const subtotal = parseFloat(subtotalText.replace('Subtotal: ', '').replace('€', '')); // Extraiem el valor numèric
                        return sum + subtotal; // Acumulem al total
                    }, 0);
                
                // Actualitzem l'element que mostra el total
                const totalElement = document.querySelector('.cart-total h3');
                if (totalElement) {
                    totalElement.textContent = `Total: ${total.toFixed(2)}€`; // Mostrem el total amb 2 decimals
                }
                
                // Comprovem si el carret ha quedat buit
                if (document.querySelectorAll('.cart-item').length === 0) {
                    // Si no queden productes, mostrem el missatge de carret buit
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
    .catch(error => console.error('Error:', error)); // Capturem i mostrem qualsevol error
}

// Funció per actualitzar el comptador de productes del carret
function updateCartCounter(count) {
    // Busquem l'element del comptador
    const counter = document.querySelector('.contador-carret');
    if (counter) {
        counter.textContent = count; // Actualitzem el text amb el nou número
    }
}

// Inicialitzem el carret quan es carrega la pàgina
document.addEventListener('DOMContentLoaded', loadCartItems); // Carreguem els productes quan el DOM està llest

// Funció per afegir un producte al carret de compra
function addToCart(id, name, price) {
    // Fa una petició POST al servidor per afegir el producte
    fetch('carret.php', {
        method: 'POST',                               // Mètode HTTP
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Format de les dades
        },
        body: `action=add&id=${id}&name=${name}&price=${price}` // Dades del producte
    })
    .then(response => response.json())                // Converteix la resposta a JSON
    .then(data => {
        if (data.success) {                         // Si s'ha afegit correctament
            // Actualitza el comptador del carret
            const counter = document.querySelector('.contador-carret');
            counter.textContent = data.count;
            
            // Afegeix un efecte d'animació al comptador
            counter.style.transform = 'scale(1.5)';   // Fa més gran el comptador
            setTimeout(() => {
                counter.style.transform = 'scale(1)'; // Torna a la mida normal
            }, 200);                                 // Després de 200ms
        }
    });
}