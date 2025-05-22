<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "elspratsdor";

if(isset($_GET['consulta']) || isset($_GET['cerca'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = null;
    $output = "";
    
    if(isset($_GET['cerca'])) {
        $terme_cerca = '%' . $conn->real_escape_string($_GET['cerca']) . '%';
        $sql = "SELECT * FROM aliments WHERE nom LIKE ? OR tipus LIKE ? ORDER BY nom";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $terme_cerca, $terme_cerca);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
    } else {
        switch($_GET['consulta']) {
        case 'exercici1':
            $output = "Connexió establerta amb èxit";
            $data = array(array("resultat" => $output));
            break;
            
        case 'exercici2':
            $sql = "INSERT INTO aliments (nom, tipus, stock, data_caducitat, preu) 
                   VALUES ('Nou Aliment', 'Cereal', 1, '2025-12-08', 1.95)";
            if ($conn->query($sql)) {
                $output = "Nou aliment inserit correctament.";
            } else {
                $output = "Error en inserir l'aliment: " . $conn->error;
            }
            $data = array(array("resultat" => $output));
            break;

        case 'exercici3':
            $sql = "SELECT nom, especie, data_naixement FROM animals ORDER BY especie DESC";
            $result = $conn->query($sql);
            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            break;

        case 'exercici4':
            $sql = "UPDATE aliments SET stock = 444 WHERE id_aliment = 2";
            if ($conn->query($sql)) {
                $files_afectades = $conn->affected_rows;
                $output = sprintf("Modificació completada correctament. Files afectades: %d", $files_afectades);
            } else {
                $output = sprintf("Error en fer la modificació: %s", $conn->error);
            }
            $data = array(array("resultat" => $output));
            break;

        case 'exercici5':
            $sql = "DELETE FROM aliments WHERE nom = 'Civada' AND preu = 0.95";
            if ($conn->query($sql)) {
                $files_afectades = $conn->affected_rows;
                if ($files_afectades > 0) {
                    $output = sprintf("Registre eliminat correctament. Files afectades: %d", $files_afectades);
                } else {
                    $output = sprintf("Cap registre eliminat. Potser ja havia estat esborrat o no existeix.");
                }
            } else {
                $output = sprintf("Error en esborrar el registre: %s", $conn->error);
            }
            $data = array(array("resultat" => $output));
            break;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultes - Els Prats d'Or</title>
    <link rel="stylesheet" href="css/style.css" />    
    <link rel="stylesheet" href="css/consultes.css" />    

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
</head>
<body>
    <header class="part_superior">
      <div class="caixa">
        <a href="index.php" class="enllac_logo">
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" />
        </a>
        <nav class="navegacio">
          <ul class="llista_menu">
            <li><a href="index.php" class="element_menu">Inici</a></li>
            <li><a href="botiga.php" class="element_menu">Botiga</a></li>
            <li><a href="formulari.php" class="element_menu">Formulari</a></li>
            <li><a href="login.php" class="boto_accedir">Accedir</a></li>
            <li>
              <a href="carret.php" class="carret-compra">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 3h1l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H6.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H4.21l-.94-2H1v2zm16 15c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
                <span class="contador-carret"><?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : '0'; ?></span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
        <section class="seccio_consultes">
            <div class="caixa">
                <h1>Exercicis Base de Dades</h1>
                <div class="cerca-container">
                    <input type="text" id="cercaInput" placeholder="Cerca per nom o tipus d'aliment..." />
                    <button onclick="handleCerca()">Cercar</button>
                </div>
                <div class="selector-container">
                    <select id="consultaSelector" onchange="handleConsultaChange()">
                        <option value="">-- Selecciona un exercici --</option>
                        <option value="exercici1">Exercici 1: Provar connexió a la base de dades</option>
                        <option value="exercici2">Exercici 2: Inserir un nou registre d'aliment</option>
                        <option value="exercici3">Exercici 3: Consulta d'animals ordenats per espècie</option>
                        <option value="exercici4">Exercici 4: Modificar stock d'un aliment</option>
                        <option value="exercici5">Exercici 5: Esborrar el registre inserit</option>
                    </select>
                </div>
                <div id="resultContainer">
                </div>
            </div>
        </section>
    </main>

    <footer class="part_inferior" id="contacte">
      <div class="caixa">
        <div class="graella graella_inferior">
          <div class="columna_inferior">
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" />
            <address>
              <p>
                📌 Cami dels Prats, 12<br />
                Conca d'Odèna
              </p>
            </address>
          </div>
          <div class="columna_inferior">
            <h3>Horari</h3>
            <p>Dilluns a Divendres</p>
            <p>9:00 - 14:00 | 16:00 - 19:00</p>
            <p>Dissabte</p>
            <p>9:00 - 14:00</p>
          </div>
          <div class="columna_inferior">
            <h3>Contacte</h3>
            <p>
              📞 <a href="tel:+34999999999" aria-label="Telèfon">999 999 999</a><br />
              ✉️ <a href="mailto:info@elspratsdor.cat">info@elspratsdor.cat</a>
            </p>
            <div class="xarxes-socials">
              <a href="#" aria-label="Instagram">
                <img src="img/instagram.png" alt="Instagram" />
              </a>
              <a href="#" aria-label="Facebook">
                <img src="img/facebook.png" alt="Facebook" />
              </a>
              <a href="#" aria-label="Twitter">
                <img src="img/twitter.png" alt="Twitter" />
              </a>
            </div>
          </div>
        </div>
        <div class="text_drets">
          &copy; 2025 Els Prats d'Or. Tots els drets reservats.
        </div>
      </div>
    </footer>

    <script>
    function handleCerca() {
        const cercaInput = document.getElementById('cercaInput');
        const terme = cercaInput.value.trim();
        const resultContainer = document.getElementById('resultContainer');

        if (!terme) {
            resultContainer.innerHTML = '<p>Si us plau, introdueix un terme de cerca.</p>';
            return;
        }

        fetch(`consultes.php?cerca=${encodeURIComponent(terme)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    resultContainer.innerHTML = '<p>No s\'han trobat resultats per la teva cerca.</p>';
                    return;
                }

                let table = '<table><thead><tr>';
                Object.keys(data[0]).forEach(key => {
                    let header = key.replace(/_/g, ' ').replace(/\w/g, l => l.toUpperCase());
                    table += `<th>${header}</th>`;
                });
                table += '</tr></thead><tbody>';

                data.forEach(row => {
                    table += '<tr>';
                    Object.values(row).forEach(value => {
                        table += `<td>${value}</td>`;
                    });
                    table += '</tr>';
                });

                table += '</tbody></table>';
                resultContainer.innerHTML = table;
            })
            .catch(error => {
                console.error('Error:', error);
                resultContainer.innerHTML = '<p>Hi ha hagut un error en processar la cerca.</p>';
            });
    }

    function handleConsultaChange() {
        const selector = document.getElementById('consultaSelector');
        const selectedValue = selector.value;
        const resultContainer = document.getElementById('resultContainer');

        if (!selectedValue) {
            resultContainer.innerHTML = '';
            return;
        }

        fetch(`consultes.php?consulta=${selectedValue}`)
            .then(response => response.json())
            .then(data => {
                if (selectedValue === 'exercici1' || selectedValue === 'exercici2' || 
                    selectedValue === 'exercici4' || selectedValue === 'exercici5') {
                    resultContainer.innerHTML = `<div class="result-message">${data[0].resultat}</div>`;
                } else {
                    if (data.length === 0) {
                        resultContainer.innerHTML = '<p>No hi ha resultats per mostrar.</p>';
                        return;
                    }

                    let table = '<table><thead><tr>';
                    Object.keys(data[0]).forEach(key => {
                        let header = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        table += `<th>${header}</th>`;
                    });
                    table += '</tr></thead><tbody>';

                    data.forEach(row => {
                        table += '<tr>';
                        Object.values(row).forEach(value => {
                            table += `<td>${value}</td>`;
                        });
                        table += '</tr>';
                    });

                    table += '</tbody></table>';
                    resultContainer.innerHTML = table;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultContainer.innerHTML = '<p>Error al cargar los resultados.</p>';
            });
    }
    </script>
</body>
</html>