<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "elspratsdor";

$message = '';
$messageType = '';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Get and sanitize form data
        $nom = trim(htmlspecialchars($_POST['nom']));
        $tipus = $_POST['tipus'];
        $stock = (int)$_POST['stock'];
        $data_caducitat = $_POST['data_caducitat'];
        $preu = (float)$_POST['preu'];
        
        $errors = [];
        
        // Validate form data
        if (strlen($nom) < 3) {
            $errors[] = "El nom ha de tenir almenys 3 caràcters";
        }
        
        if (empty($tipus)) {
            $errors[] = "Has de seleccionar un tipus de producte";
        }
        
        if ($stock < 0 || $stock > 100) {
            $errors[] = "L'stock ha d'estar entre 0 i 100";
        }
        
        if (empty($data_caducitat)) {
            $errors[] = "La data de caducitat és obligatòria";
        }
        
        if ($preu <= 0) {
            $errors[] = "El preu ha de ser major que 0";
        }
        
        // If no errors, insert into database
        if (empty($errors)) {
            $sql = "INSERT INTO productes (nom, tipus, stock, data_caducitat, preu) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiss", $nom, $tipus, $stock, $data_caducitat, $preu);
            
            if ($stmt->execute()) {
                $message = "Producte afegit correctament!";
                $messageType = "success";
                // Clear form data
                $_POST = array();
            } else {
                $message = "Error: " . $stmt->error;
                $messageType = "error";
            }
            $stmt->close();
        } else {
            $message = "Errors de validació:<br>" . implode("<br>", $errors);
            $messageType = "error";
        }
    } elseif (isset($_POST['clear'])) {
        // Clear form data and messages
        $_POST = array();
        $message = '';
        $messageType = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum=1" />
  <meta name="description" content="Granja ecològica familiar a la Conca d'Odèna. Productes naturals i artesans amb tradició des de 1985." />
  <title>Els Prats d'Or - Formulari</title>
  <link rel="stylesheet" href="css/formulari.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
</head>
<body>
    <header class="part_superior">
        <div class="caixa">
          <a href="index.html" class="enllac_logo">
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" />
          </a>
          <nav class="navegacio">
            <ul class="llista_menu">
              <li><a href="index.html" class="element_menu">Inici</a></li>
              <li><a href="botiga.html" class="element_menu">Botiga</a></li>
              <li><a href="formulari.html" class="element_menu">Formulari</a></li>
              <li><a href="login.html" class="boto_accedir">Accedir</a></li>
              <li>
                <a href="#" class="carret-compra">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 3h1l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H6.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H4.21l-.94-2H1v2zm16 15c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                  </svg>
                  <span class="contador-carret">0</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </header>
  <main>
    <section>
      <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
      <?php endif; ?>
      <form class="formulari" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
          <label for="nom">Nom:</label>
          <input type="text" id="nom" name="nom" required placeholder="Introdueix el nom del producte" minlength="3" 
                 value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
        </div>
        <div>
          <label for="tipus">Tipus:</label>
          <select id="tipus" name="tipus" required>
            <option value="" disabled <?php echo !isset($_POST['tipus']) ? 'selected' : ''; ?>>Selecciona el tipus</option>
            <?php
            $tipus_options = ['fruita', 'verdura', 'cereal', 'lactic', 'altres'];
            foreach ($tipus_options as $option) {
                $selected = (isset($_POST['tipus']) && $_POST['tipus'] === $option) ? 'selected' : '';
                echo "<option value=\"$option\" $selected>" . ucfirst($option) . "</option>";
            }
            ?>
          </select>
        </div>
        <div>
          <label for="stock">Stock:</label>
          <input type="number" id="stock" name="stock" min="0" max="100" 
                 value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : '0'; ?>">
        </div>
        <div>
          <label for="data_caducitat">Data de Caducitat:</label>
          <input type="date" id="data_caducitat" name="data_caducitat" required 
                 value="<?php echo isset($_POST['data_caducitat']) ? htmlspecialchars($_POST['data_caducitat']) : ''; ?>">
        </div>
        <div>
          <label for="preu">Preu:</label>
          <input type="number" id="preu" name="preu" min="0" step="0.01" 
                 value="<?php echo isset($_POST['preu']) ? htmlspecialchars($_POST['preu']) : '0.00'; ?>">
        </div>
        <div class="botons">
          <button type="submit" name="submit" class="boto-submit">Donar d'alta</button>
          <button type="submit" name="clear" class="boto-clear">Netejar formulari</button>
        </div>
      </form>
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
</body>
</html>