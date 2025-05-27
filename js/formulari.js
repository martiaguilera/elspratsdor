/**
 * Funcions de validació globals
 */

// Inicialitza els esdeveniments de validació per cada camp
document.addEventListener('DOMContentLoaded', () => {
    Object.keys(validadors).forEach(campId => {
        const element = document.getElementById(campId);
        if (element) {
            element.addEventListener('blur', () => validarCamp(element));
        }
    });
});

function validarCamp(element) {
    // Eliminar missatge anterior si existeix
    const contenidorPare = element.parentElement;
    const missatgeAnterior = contenidorPare.querySelector('.missatge-validacio');
    if (missatgeAnterior) {
        missatgeAnterior.remove();
    }

    // Obtenir el resultat de la validació
    let resultat;
    switch(element.id) {
        case 'nom':
            resultat = validarNom(element.value);
            break;
        case 'tipus':
            resultat = validarTipus(element.value);
            break;
        case 'stock':
            resultat = validarStock(element.value);
            break;
        case 'data_caducitat':
            resultat = validarDataCaducitat(element.value);
            break;
        case 'preu':
            resultat = validarPreu(element.value);
            break;
    }

    // Crear i mostrar el missatge
    const missatge = document.createElement('div');
    missatge.className = `missatge-validacio ${resultat.valid ? 'valid' : 'invalid'}`;
    missatge.textContent = resultat.valid ? '✓' : resultat.missatge;
    
    // Aplicar estils
    aplicarEstils(element, missatge, resultat.valid);
    
    // Afegir el missatge
    contenidorPare.appendChild(missatge);
}

function aplicarEstils(element, missatge, esValid) {
    element.style.borderColor = esValid ? '#4CAF50' : '#f44336';
    missatge.style.color = esValid ? '#4CAF50' : '#f44336';
    missatge.style.fontSize = '0.8em';
    missatge.style.marginTop = '5px';
}

function validarNom(valor) {
    // Expressió regular que només permet lletres, espais i caràcters catalans
    const nomRegex = /^[a-zA-ZàáèéíòóúñÀÁÈÉÍÒÓÚÑçÇ\s]+$/;
    
    if (!nomRegex.test(valor)) {
        return {
            valid: false,
            missatge: 'El nom només pot contenir lletres (no s\'accepten números)'
        };
    }
    
    return {
        valid: valor.length >= 3,
        missatge: 'El nom ha de tenir almenys 3 caràcters'
    };
}

function validarTipus(valor) {
    return {
        valid: valor !== '',
        missatge: 'Has de seleccionar un tipus de producte'
    };
}

function validarStock(valor) {
    const quantitat = parseInt(valor);
    return {
        valid: !isNaN(quantitat) && quantitat >= 0 && quantitat <= 100,
        missatge: "L'stock ha d'estar entre 0 i 100"
    };
}

function validarDataCaducitat(valor) {
    return {
        valid: valor !== '',
        missatge: 'La data de caducitat és obligatòria'
    };
}

function validarPreu(valor) {
    const preu = parseFloat(valor);
    return {
        valid: !isNaN(preu) && preu > 0,
        missatge: 'El preu ha de ser major que 0'
    };
}