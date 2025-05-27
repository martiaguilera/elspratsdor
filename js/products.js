// Arxiu per gestionar els efectes visuals i la interacció amb els productes

// Funció per mostrar l'efecte hover quan el ratolí passa per sobre d'un producte
function showHoverEffect(element) {
    element.style.transform = 'translateY(-5px)';
    element.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
}

// Funció per eliminar l'efecte hover quan el ratolí surt del producte
function removeHoverEffect(element) {
    element.style.transform = 'translateY(0)';
    element.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
}
