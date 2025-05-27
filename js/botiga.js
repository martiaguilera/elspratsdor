// Arxiu per gestionar els efectes visuals i la interacció amb els productes de la botiga

// Funció que aplica un efecte de flotació quan el ratolí passa per sobre d'un element
function hoverEffect(element) {
    element.style.transform = 'translateY(-10px)';      // Mou l'element 10px cap amunt
    element.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';  // Afegeix una ombra més pronunciada
    element.style.transition = 'all 0.3s ease';        // Suavitza la transició
}

// Funció que retorna l'element al seu estat normal
function normalEffect(element) {
    element.style.transform = 'translateY(0)';         // Torna l'element a la seva posició original
    element.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';   // Restaura l'ombra normal
    element.style.transition = 'all 0.3s ease';        // Manté la transició suau
}

// Funció que mostra efectes visuals avançats quan el ratolí passa per sobre d'un producte
function showHoverEffect(element) {
    element.style.transform = 'scale(1.05)';           // Augmenta lleugerament la mida del producte
    element.style.boxShadow = '0 8px 20px rgba(0,0,0,0.2)';  // Afegeix una ombra més gran
    element.style.backgroundColor = '#f9f9f9';        // Canvia el color de fons
    
    // Busca i modifica la imatge del producte si existeix
    const image = element.querySelector('.product-image');
    if (image) {
        image.style.transform = 'scale(1.1)';        // Fa la imatge una mica més gran
    }
    
    // Busca i modifica el preu del producte si existeix
    const price = element.querySelector('.product-price');
    if (price) {
        price.style.color = 'var(--color-secundari)'; // Canvia el color del preu
        price.style.fontSize = '1.5rem';              // Augmenta la mida del text
    }
}

// Funció que elimina els efectes visuals quan el ratolí surt del producte
function removeHoverEffect(element) {
    element.style.transform = 'scale(1)';             // Torna el producte a la seva mida original
    element.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';   // Restaura l'ombra normal
    element.style.backgroundColor = 'white';          // Torna al color de fons original
    
    // Restaura la mida original de la imatge
    const image = element.querySelector('.product-image');
    if (image) {
        image.style.transform = 'scale(1)'
    }
    
    // Restaura l'estil original del preu
    const price = element.querySelector('.product-price');
    if (price) {
        price.style.color = 'var(--color-primari)';  // Torna al color original
        price.style.fontSize = '1.4rem';              // Torna a la mida original
    }
}

