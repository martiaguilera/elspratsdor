function hoverEffect(element) {
    element.style.transform = 'translateY(-10px)';
    element.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
    element.style.transition = 'all 0.3s ease';
}

function normalEffect(element) {
    element.style.transform = 'translateY(0)';
    element.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
    element.style.transition = 'all 0.3s ease';
}

function showHoverEffect(element) {
    element.style.transform = 'scale(1.05)';
    element.style.boxShadow = '0 8px 20px rgba(0,0,0,0.2)';
    element.style.backgroundColor = '#f9f9f9';
    
    const image = element.querySelector('.product-image');
    if (image) {
        image.style.transform = 'scale(1.1)';
    }
    
    const price = element.querySelector('.product-price');
    if (price) {
        price.style.color = 'var(--color-secundari)';
        price.style.fontSize = '1.5rem';
    }
}

function removeHoverEffect(element) {
    element.style.transform = 'scale(1)';
    element.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
    element.style.backgroundColor = 'white';
    
    const image = element.querySelector('.product-image');
    if (image) {
        image.style.transform = 'scale(1)';
    }
    
    const price = element.querySelector('.product-price');
    if (price) {
        price.style.color = 'var(--color-primari)';
        price.style.fontSize = '1.4rem';
    }
}

function addToCart(id, name, price) {
    fetch('carret.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add&id=${id}&name=${name}&price=${price}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart counter
            const counter = document.querySelector('.contador-carret');
            counter.textContent = data.count;
            
            // Add animation effect
            counter.style.transform = 'scale(1.5)';
            setTimeout(() => {
                counter.style.transform = 'scale(1)';
            }, 200);
        }
    });
}