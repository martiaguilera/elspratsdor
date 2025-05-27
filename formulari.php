<?php
session_start(); // Iniciem la sessió per mantenir les dades de l'usuari
$servername = "127.0.0.1"; // Adreça del nostre servidor local
$username = "root"; // Usuari per accedir a la base de dades
$password = ""; // Contrasenya (buida en desenvolupament local)
$dbname = "elspratsdor"; // Nom de la nostra base de dades

$message = ''; // Variable per guardar els missatges de feedback
$messageType = ''; // Tipus de missatge (èxit o error)

$conn = new mysqli($servername, $username, $password, $dbname); // Connectem amb la base de dades

if ($conn->connect_error) { // Si hi ha un error de connexió...
    die("Connexio sense exit: " . $conn->connect_error); // Mostrem l'error i aturem l'execució
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si hem rebut dades del formulari...
    if (isset($_POST['submit'])) { // Si s'ha enviat el formulari...
        $nom = trim(htmlspecialchars($_POST['nom'])); // Netegem el nom d'espais i caràcters especials
        $tipus = $_POST['tipus']; // Obtenim el tipus de producte
        $stock = (int)$_POST['stock']; // Convertim l'stock a número enter
        $data_caducitat = $_POST['data_caducitat']; // Data de caducitat del producte
        $preu = (float)$_POST['preu']; // Convertim el preu a número decimal
        
        $errors = []; // Array per guardar els possibles errors
        
        if (strlen($nom) < 3) { // Si el nom és massa curt...
            $errors[] = "El nom ha de tenir almenys 3 caràcters"; // Afegim l'error
        }
        
        if (empty($tipus)) { // Si no s'ha seleccionat un tipus...
            $errors[] = "Has de seleccionar un tipus de producte"; // Afegim l'error
        }
        
        if ($stock < 0 || $stock > 100) { // Si l'stock està fora del rang...
            $errors[] = "L'stock ha d'estar entre 0 i 100"; // Afegim l'error
        }
        
        if (empty($data_caducitat)) { // Si no s'ha especificat la data...
            $errors[] = "La data de caducitat és obligatòria"; // Afegim l'error
        }
        
        if ($preu <= 0) { // Si el preu no és vàlid...
            $errors[] = "El preu ha de ser major que 0"; // Afegim l'error
        }
        
        if (empty($errors)) { // Si no hi ha errors de validació...
            $sql = "INSERT INTO aliments (nom, tipus, stock, data_caducitat, preu) VALUES (?, ?, ?, ?, ?)"; // Preparem la consulta SQL
            $stmt = $conn->prepare($sql); // Preparem la sentència
            $stmt->bind_param("ssiss", $nom, $tipus, $stock, $data_caducitat, $preu); // Vinculem els paràmetres
            
            if ($stmt->execute()) { // Si la inserció ha anat bé...
                $message = "Producte afegit correctament!"; // Missatge d'èxit
                $messageType = "success"; // Tipus de missatge
                $_POST = array(); // Netegem les dades del formulari
            } else { // Si hi ha hagut un error...
                $message = "Error: " . $stmt->error; // Missatge d'error
                $messageType = "error"; // Tipus de missatge
            }
            $stmt->close(); // Tanquem la sentència preparada
        } else { // Si hi ha errors de validació...
            $message = "Errors de validació:<br>" . implode("<br>", $errors); // Mostrem tots els errors
            $messageType = "error"; // Tipus de missatge
        }
    } elseif (isset($_POST['clear'])) { // Si s'ha clicat el botó de netejar...
        $_POST = array(); // Netejem les dades del formulari
        $message = ''; // Netejem el missatge
        $messageType = ''; // Netejem el tipus de missatge
    }
}
?>
<!DOCTYPE html> <!-- Definim el tipus de document -->
<html lang="ca"> <!-- Iniciem el document HTML en català -->
<head> <!-- Secció de metadades i recursos -->
  <meta charset="UTF-8" /> <!-- Codificació de caràcters UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum=1" /> <!-- Configuració per a dispositius mòbils -->
  <meta name="description" content="Granja ecològica familiar a la Conca d'Odèna. Productes naturals i artesans amb tradició des de 1985." /> <!-- Descripció per als motors de cerca -->
  <title>Els Prats d'Or - Formulari</title> <!-- Títol de la pàgina -->
  <link rel="stylesheet" href="css/formulari.css" /> <!-- Estils específics del formulari -->
  <link rel="stylesheet" href="css/style.css" /> <!-- Estils generals del lloc web -->
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
    <section> <!-- Secció del formulari -->
      <?php if (!empty($message)): ?> <!-- Si hi ha un missatge per mostrar... -->
        <div class="message <?php echo $messageType; ?>"> <!-- Contenidor del missatge amb el seu tipus -->
            <?php echo $message; ?> <!-- Mostrem el missatge -->
        </div>
      <?php endif; ?>
      <form class="formulari" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Formulari que s'envia a la mateixa pàgina -->
        <div> <!-- Camp pel nom del producte -->
          <label for="nom">Nom:</label> <!-- Etiqueta del camp -->
          <input type="text" id="nom" name="nom" required placeholder="Introdueix el nom del producte" minlength="3" 
                 value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>"
                 onblur="validarCamp(this)"> <!-- Camp de text amb validació -->
        </div>
        <div> <!-- Selector del tipus de producte -->
          <label for="tipus">Tipus:</label> <!-- Etiqueta del selector -->
          <select id="tipus" name="tipus" required onblur="validarCamp(this)"> <!-- Llista desplegable -->
            <option value="" disabled <?php echo !isset($_POST['tipus']) ? 'selected' : ''; ?>>Selecciona el tipus</option> <!-- Opció per defecte -->
            <?php            $tipus_options = [ // Array amb els tipus de productes disponibles
                'Cereal',
                'Làctics',
                'Herba',
                'Hortalissa',
                'Fruita',
                'Avícola',
                'Mel',
                'Conserva'
            ];
            foreach ($tipus_options as $option) { // Per cada tipus de producte...
                $selected = (isset($_POST['tipus']) && $_POST['tipus'] === $option) ? 'selected' : ''; // Marquem si estava seleccionat
                echo "<option value=\"$option\" $selected>" . $option . "</option>"; // Creem l'opció
            }
            ?>
          </select>
        </div>
        <div> <!-- Camp per l'stock -->
          <label for="stock">Stock:</label> <!-- Etiqueta del camp -->
          <input type="number" id="stock" name="stock" min="0" max="100" 
                 value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : '0'; ?>"
                 onblur="validarCamp(this)"> <!-- Camp numèric amb límits -->
        </div>
        <div> <!-- Camp per la data de caducitat -->
          <label for="data_caducitat">Data de Caducitat:</label> <!-- Etiqueta del camp -->
          <input type="date" id="data_caducitat" name="data_caducitat" required 
                 value="<?php echo isset($_POST['data_caducitat']) ? htmlspecialchars($_POST['data_caducitat']) : ''; ?>"
                 onblur="validarCamp(this)"> <!-- Selector de data -->
        </div>
        <div> <!-- Camp pel preu -->
          <label for="preu">Preu:</label> <!-- Etiqueta del camp -->
          <input type="number" id="preu" name="preu" min="0" step="0.01" 
                 value="<?php echo isset($_POST['preu']) ? htmlspecialchars($_POST['preu']) : '0.00'; ?>"
                 onblur="validarCamp(this)"> <!-- Camp numèric amb decimals -->
        </div>
        <div class="botons"> <!-- Contenidor dels botons -->
          <button type="submit" name="submit" class="boto-submit">Donar d'alta</button> <!-- Botó per enviar el formulari -->
          <button type="submit" name="clear" class="boto-clear">Netejar formulari</button> <!-- Botó per netejar el formulari -->
        </div>
      </form>
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
  <script src="js/formulari.js"></script>
</body>
</html>