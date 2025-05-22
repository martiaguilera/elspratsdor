// Funcions per als efectes visuals dels productes
function showHoverEffect(element) {
    element.classList.add('hover');
}

function removeHoverEffect(element) {
    element.classList.remove('hover');
}

// Funció per afegir productes al carret
function addToCart(productId, productName, price) {
    fetch('carret.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add&id=${productId}&name=${encodeURIComponent(productName)}&price=${price}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCounter(data.count);
            // Mostrar feedback visual
            const button = document.querySelector(`button[onclick*="${productId}"]`);
            if (button) {
                const originalText = button.textContent;
                button.textContent = 'Afegit!';
                setTimeout(() => {
                    button.textContent = originalText;
                }, 1000);
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
