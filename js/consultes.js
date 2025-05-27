function handleCerca() { // Funció per gestionar la cerca
    const cercaInput = document.getElementById('cercaInput'); // Obtenim el camp de cerca
    const terme = cercaInput.value.trim(); // Obtenim el terme de cerca sense espais
    const resultContainer = document.getElementById('resultContainer'); // Contenidor pels resultats

    if (!terme) { // Si no hi ha terme de cerca...
        resultContainer.innerHTML = '<p>Si us plau, introdueix un terme de cerca.</p>'; // Mostrem missatge
        return;
    }

    fetch(`consultes.php?cerca=${encodeURIComponent(terme)}`) // Fem la petició al servidor
        .then(response => response.json()) // Convertim la resposta a JSON
        .then(data => { // Processem les dades
            if (data.length === 0) { // Si no hi ha resultats...
                resultContainer.innerHTML = '<p>No s\'han trobat resultats per la teva cerca.</p>'; // Mostrem missatge
                return;
            }

            let table = '<table><thead><tr>'; // Creem la taula de resultats
            Object.keys(data[0]).forEach(key => { // Per cada columna...
                let header = key.replace(/_/g, ' ').replace(/\w/g, l => l.toUpperCase()); // Formatem el nom
                table += `<th>${header}</th>`; // Afegim la capçalera
            });
            table += '</tr></thead><tbody>'; // Tanquem la capçalera

            data.forEach(row => { // Per cada fila de resultats...
                table += '<tr>'; // Creem una fila
                Object.values(row).forEach(value => { // Per cada valor...
                    table += `<td>${value}</td>`; // Afegim una cel·la
                });
                table += '</tr>'; // Tanquem la fila
            });

            table += '</tbody></table>'; // Tanquem la taula
            resultContainer.innerHTML = table; // Mostrem la taula
        })
        .catch(error => { // Si hi ha un error...
            console.error('Error:', error); // Registrem l'error
            resultContainer.innerHTML = '<p>Hi ha hagut un error en processar la cerca.</p>'; // Mostrem missatge d'error
        });
}

function handleConsultaChange() { // Funció per gestionar el canvi de consulta
    const selector = document.getElementById('consultaSelector'); // Obtenim el selector
    const selectedValue = selector.value; // Obtenim el valor seleccionat
    const resultContainer = document.getElementById('resultContainer'); // Contenidor pels resultats

    if (!selectedValue) { // Si no hi ha valor seleccionat...
        resultContainer.innerHTML = ''; // Netejem el contenidor
        return;
    }

    fetch(`consultes.php?consulta=${selectedValue}`) // Fem la petició al servidor
        .then(response => response.json()) // Convertim la resposta a JSON
        .then(data => { // Processem les dades
            if (selectedValue === 'exercici1' || selectedValue === 'exercici2' || 
                selectedValue === 'exercici4' || selectedValue === 'exercici5') { // Si és un exercici amb missatge...
                resultContainer.innerHTML = `<div class="result-message">${data[0].resultat}</div>`; // Mostrem el missatge
            } else { // Si és un exercici amb taula...
                if (data.length === 0) { // Si no hi ha resultats...
                    resultContainer.innerHTML = '<p>No hi ha resultats per mostrar.</p>'; // Mostrem missatge
                    return;
                }

                let table = '<table><thead><tr>'; // Creem la taula
                Object.keys(data[0]).forEach(key => { // Per cada columna...
                    let header = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()); // Formatem el nom
                    table += `<th>${header}</th>`; // Afegim la capçalera
                });
                table += '</tr></thead><tbody>'; // Tanquem la capçalera

                data.forEach(row => { // Per cada fila de resultats...
                    table += '<tr>'; // Creem una fila
                    Object.values(row).forEach(value => { // Per cada valor...
                        table += `<td>${value}</td>`; // Afegim una cel·la
                    });
                    table += '</tr>'; // Tanquem la fila
                });

                table += '</tbody></table>'; // Tanquem la taula
                resultContainer.innerHTML = table; // Mostrem la taula
            }
        })
        .catch(error => { // Si hi ha un error...
            console.error('Error:', error); // Registrem l'error
            resultContainer.innerHTML = '<p>Error al cargar los resultados.</p>'; // Mostrem missatge d'error
        });
}