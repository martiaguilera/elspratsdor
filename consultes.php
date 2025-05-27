<?php
session_start(); // Iniciem la sessió per mantenir les dades de l'usuari
$servername = "127.0.0.1"; // Adreça del nostre servidor local
$username = "root"; // Usuari per accedir a la base de dades
$password = ""; // Contrasenya (buida en desenvolupament local)
$dbname = "elspratsdor"; // Nom de la nostra base de dades

if(isset($_GET['consulta']) || isset($_GET['cerca'])) { // Comprovem si hem rebut una consulta o una cerca
    $conn = new mysqli($servername, $username, $password, $dbname); // Connectem amb la base de dades
    
    if ($conn->connect_error) { // Si hi ha un error de connexió...
        die("Connection failed: " . $conn->connect_error); // Mostrem l'error i aturem l'execució
    }

    $result = null; // Variable per guardar el resultat de les consultes
    $output = ""; // Variable per guardar els missatges de sortida
    
    if(isset($_GET['cerca'])) { // Si estem fent una cerca...
        $terme_cerca = '%' . $conn->real_escape_string($_GET['cerca']) . '%'; // Preparem el terme de cerca per usar amb LIKE
        $sql = "SELECT * FROM aliments WHERE nom LIKE ? OR tipus LIKE ? ORDER BY nom"; // Consulta SQL per buscar per nom o tipus
        $stmt = $conn->prepare($sql); // Preparem la consulta per evitar injeccions SQL
        $stmt->bind_param('ss', $terme_cerca, $terme_cerca); // Vinculem els paràmetres de cerca
        $stmt->execute(); // Executem la consulta
        $result = $stmt->get_result(); // Obtenim els resultats
        $data = array(); // Array per guardar les dades
        if ($result->num_rows > 0) { // Si hem trobat resultats...
            while($row = $result->fetch_assoc()) { // Per cada fila de resultats...
                $data[] = $row; // Afegim la fila a l'array de dades
            }
        }
        $stmt->close(); // Tanquem la consulta preparada
    } else { // Si no és una cerca, mirem quin exercici hem de fer
        switch($_GET['consulta']) {
        case 'exercici1': // Exercici 1: Provar la connexió
            $output = "Connexió establerta amb èxit"; // Missatge d'èxit
            $data = array(array("resultat" => $output)); // Formatem la sortida
            break;
            
        case 'exercici2': // Exercici 2: Inserir un nou aliment
            $sql = "INSERT INTO aliments (nom, tipus, stock, data_caducitat, preu) 
                   VALUES ('Nou Aliment', 'Cereal', 1, '2025-12-08', 1.95)"; // Consulta d'inserció
            if ($conn->query($sql)) { // Si la inserció ha anat bé...
                $output = "Nou aliment inserit correctament."; // Missatge d'èxit
            } else { // Si hi ha hagut un error...
                $output = "Error en inserir l'aliment: " . $conn->error; // Missatge d'error
            }
            $data = array(array("resultat" => $output)); // Formatem la sortida
            break;

        case 'exercici3': // Exercici 3: Consultar animals
            $sql = "SELECT nom, especie, data_naixement FROM animals ORDER BY especie DESC"; // Consulta per obtenir animals
            $result = $conn->query($sql); // Executem la consulta
            $data = array(); // Array per guardar les dades
            if ($result->num_rows > 0) { // Si hem trobat resultats...
                while($row = $result->fetch_assoc()) { // Per cada fila de resultats...
                    $data[] = $row; // Afegim la fila a l'array de dades
                }
            }
            break;

        case 'exercici4': // Exercici 4: Actualitzar stock
            $sql = "UPDATE aliments SET stock = 444 WHERE id_aliment = 2"; // Consulta d'actualització
            if ($conn->query($sql)) { // Si l'actualització ha anat bé...
                $files_afectades = $conn->affected_rows; // Obtenim el nombre de files afectades
                $output = sprintf("Modificació completada correctament. Files afectades: %d", $files_afectades); // Missatge d'èxit
            } else { // Si hi ha hagut un error...
                $output = sprintf("Error en fer la modificació: %s", $conn->error); // Missatge d'error
            }
            $data = array(array("resultat" => $output)); // Formatem la sortida
            break;

        case 'exercici5': // Exercici 5: Esborrar un registre
            $sql = "DELETE FROM aliments WHERE nom = 'Nou Aliment' AND preu = 1.95"; // Consulta d'eliminació
            if ($conn->query($sql)) { // Si l'eliminació ha anat bé...
                $files_afectades = $conn->affected_rows; // Obtenim el nombre de files afectades
                if ($files_afectades > 0) { // Si s'ha eliminat algun registre...
                    $output = sprintf("Registre eliminat correctament. Files afectades: %d", $files_afectades); // Missatge d'èxit
                } else { // Si no s'ha eliminat cap registre...
                    $output = sprintf("Cap registre eliminat. Potser ja havia estat esborrat o no existeix."); // Missatge informatiu
                }
            } else { // Si hi ha hagut un error...
                $output = sprintf("Error en esborrar el registre: %s", $conn->error); // Missatge d'error
            }
            $data = array(array("resultat" => $output)); // Formatem la sortida
            break;
        }
    }
    
    header('Content-Type: application/json'); // Indiquem que la resposta serà en format JSON
    echo json_encode($data); // Enviem les dades en format JSON
    $conn->close(); // Tanquem la connexió amb la base de dades
    exit; // Acabem l'execució
}
?>
<!DOCTYPE html> <!-- Definim el tipus de document -->
<html lang="ca"> <!-- Iniciem el document HTML en català -->
<head> <!-- Secció de metadades i recursos -->
    <meta charset="UTF-8"> <!-- Codificació de caràcters UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuració per a dispositius mòbils -->
    <title>Consultes - Els Prats d'Or</title> <!-- Títol de la pàgina -->
    <link rel="stylesheet" href="css/style.css" /> <!-- Estils generals del lloc web -->
    <link rel="stylesheet" href="css/consultes.css" /> <!-- Estils específics per a les consultes -->

    <link rel="preconnect" href="https://fonts.googleapis.com" /> <!-- Preconnexió amb Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> <!-- Preconnexió amb el CDN de fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" /> <!-- Càrrega de les fonts -->
</head>
<body> <!-- Cos de la pàgina -->
    <header class="part_superior"> <!-- Capçalera de la pàgina -->
      <div class="caixa"> <!-- Contenidor principal -->
        <a href="index.php" class="enllac_logo"> <!-- Enllaç al logo -->
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" /> <!-- Logo de la granja -->
        </a>
        <nav class="navegacio"> <!-- Menú de navegació -->
          <ul class="llista_menu"> <!-- Llista d'elements del menú -->
            <li><a href="index.php" class="element_menu">Inici</a></li> <!-- Enllaç a la pàgina d'inici -->
            <li><a href="botiga.php" class="element_menu">Botiga</a></li> <!-- Enllaç a la botiga -->
            <li><a href="formulari.php" class="element_menu">Formulari</a></li> <!-- Enllaç al formulari -->
            <li><a href="login.php" class="boto_accedir">Accedir</a></li> <!-- Botó d'accés -->
            <li> <!-- Element del carret de compra -->
              <a href="carret.php" class="carret-compra"> <!-- Enllaç al carret -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"> <!-- Icona del carret -->
                  <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 3h1l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H6.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H4.21l-.94-2H1v2zm16 15c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
                <span class="contador-carret"><?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : '0'; ?></span> <!-- Comptador d'items al carret -->
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <main> <!-- Contingut principal -->
        <section class="seccio_consultes"> <!-- Secció de consultes -->
            <div class="caixa"> <!-- Contenidor principal -->
                <h1>Exercicis Base de Dades</h1> <!-- Títol de la secció -->
                <div class="cerca-container"> <!-- Contenidor del cercador -->
                    <input type="text" id="cercaInput" placeholder="Cerca per nom o tipus d'aliment..." /> <!-- Camp de cerca -->
                    <button onclick="handleCerca()">Cercar</button> <!-- Botó de cerca -->
                </div>
                <div class="selector-container"> <!-- Contenidor del selector d'exercicis -->
                    <select id="consultaSelector" onchange="handleConsultaChange()"> <!-- Selector d'exercicis --><!--Exercici 3 Part 4 -->
                        <option value="">-- Selecciona un exercici --</option> <!-- Opció per defecte -->
                        <option value="exercici1">Exercici 1: Provar connexió a la base de dades</option> <!-- Opció exercici 1 -->
                        <option value="exercici2">Exercici 2: Inserir un nou registre d'aliment</option> <!-- Opció exercici 2 -->
                        <option value="exercici3">Exercici 3: Consulta d'animals ordenats per espècie</option> <!-- Opció exercici 3 -->
                        <option value="exercici4">Exercici 4: Modificar stock d'un aliment</option> <!-- Opció exercici 4 -->
                        <option value="exercici5">Exercici 5: Esborrar el registre inserit</option> <!-- Opció exercici 5 -->
                    </select>
                </div>
                <div id="resultContainer"></div> <!-- Contenidor pels resultats -->
            </div>
        </section>
    </main>

    <footer class="part_inferior" id="contacte"> <!-- Peu de pàgina -->
      <div class="caixa"> <!-- Contenidor principal -->
        <div class="graella graella_inferior"> <!-- Graella del peu de pàgina -->
          <div class="columna_inferior"> <!-- Primera columna -->
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" /> <!-- Logo al peu -->
            <address> <!-- Adreça de contacte -->
              <p>
                📌 Cami dels Prats, 12<br /> <!-- Adreça física -->
                Conca d'Odèna
              </p>
            </address>
          </div>
          <div class="columna_inferior"> <!-- Segona columna -->
            <h3>Horari</h3> <!-- Secció d'horaris -->
            <p>Dilluns a Divendres</p>
            <p>9:00 - 14:00 | 16:00 - 19:00</p>
            <p>Dissabte</p>
            <p>9:00 - 14:00</p>
          </div>
          <div class="columna_inferior"> <!-- Tercera columna -->
            <h3>Contacte</h3> <!-- Secció de contacte -->
            <p>
              📞 <a href="tel:+34999999999" aria-label="Telèfon">999 999 999</a><br /> <!-- Telèfon de contacte -->
              ✉️ <a href="mailto:info@elspratsdor.cat">info@elspratsdor.cat</a> <!-- Correu electrònic -->
            </p>
            <div class="xarxes-socials"> <!-- Xarxes socials -->
              <a href="#" aria-label="Instagram"> <!-- Enllaç a Instagram -->
                <img src="img/instagram.png" alt="Instagram" />
              </a>
              <a href="#" aria-label="Facebook"> <!-- Enllaç a Facebook -->
                <img src="img/facebook.png" alt="Facebook" />
              </a>
              <a href="#" aria-label="Twitter"> <!-- Enllaç a Twitter -->
                <img src="img/twitter.png" alt="Twitter" />
              </a>
            </div>
          </div>
        </div>
        <div class="text_drets"> <!-- Text de drets d'autor -->
          &copy; 2025 Els Prats d'Or. Tots els drets reservats.
        </div>
      </div>
    </footer>

    <script src="js/consultes.js"></script> <!-- Carreguem el fitxer JavaScript extern -->
</body>
</html>