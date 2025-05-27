<?php
// Inicialitzem la sessió per mantenir l'estat del carret entre diferents pàgines
session_start(); // Això permet que les dades del carret persisteixin mentre l'usuari navega pel lloc web

// Configuració de la connexió a la base de dades MySQL
$servername = "127.0.0.1";  // Adreça IP del servidor de base de dades (localhost)
$username = "root";         // Nom d'usuari per accedir a la base de dades (per defecte en XAMPP)
$password = "";            // Contrasenya d'accés (buida en entorn de desenvolupament)
$dbname = "elspratsdor";   // Nom de la base de dades que conté les taules del projecte

// Establim la connexió amb la base de dades utilitzant l'objecte mysqli
$conn = new mysqli($servername, $username, $password, $dbname); // Creem una nova instància de connexió

// Comprovem si la connexió s'ha establert correctament
if ($conn->connect_error) { // Si hi ha hagut algun error durant la connexió
    die("Connection failed: " . $conn->connect_error); // Aturem l'execució i mostrem el missatge d'error
}

// Preparem i executem la consulta SQL per obtenir tots els productes
$sql = "SELECT * FROM aliments ORDER BY tipus"; // Seleccionem tots els productes ordenats per tipus
$result = $conn->query($sql); // Executem la consulta i guardem el resultat
?>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> <!-- Important per al disseny responsive en mòbils i tauletes. Controla com es mostra l'ample i l'escala de la pàgina. -->
    <meta name="description" content="Botiga online amb productes ecològics i artesans de la granja Els Prats d'Or." /> <!-- Això defineix una descripció de la pàgina web que es veu als cercadors com Google, per exemple. -->
    <title>Botiga - Els Prats d'Or</title>
    <link rel="stylesheet" href="css/botiga.css" /> 
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com" /> <!-- Preconnecta amb els servidors de Google Fonts per agilitzar la càrrega de les lletres. -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> <!--  Igual que abans però per les fonts estàtiques (en general, les lletres).-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />    <!-- Carreguem els scripts necessaris per la funcionalitat de la botiga -->
    <script src="js/botiga.js" defer></script> <!-- Script principal amb funcions generals de la botiga -->
    <script src="js/cart.js" defer></script> <!-- Gestiona les funcionalitats del carret de compra -->
    <script src="js/products.js" defer></script> <!-- Gestiona la visualització i interacció amb els productes -->
  </head>
  <body>
    <!-- Capçalera principal del lloc web -->
    <header class="part_superior"> <!-- Conté la navegació i el logo, fixada a la part superior -->
      <div class="caixa"> <!-- Contenidor per centrar i limitar l'amplada del contingut -->
        <!-- Enllaç al logo que porta a la pàgina principal -->
        <a href="index.php" class="enllac_logo"> <!-- L'enllaç envolta la imatge del logo -->
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" /> <!-- Imatge del logo amb text alternatiu per accessibilitat -->
        </a>
        <!-- Navegació principal del lloc web -->
        <nav class="navegacio"> <!-- Menú de navegació principal -->
          <ul class="llista_menu"> <!-- Llista no ordenada pels elements del menú -->
            <!-- Elements de navegació amb els seus enllaços corresponents -->
            <li><a href="index.php" class="element_menu">Inici</a></li> <!-- Enllaç a la pàgina principal -->
            <li><a href="botiga.php" class="element_menu">Botiga</a></li> <!-- Enllaç a la pàgina actual de la botiga -->
            <li><a href="formulari.php" class="element_menu">Formulari</a></li> <!-- Enllaç al formulari de contacte -->
            <li><a href="login.php" class="boto_accedir">Accedir</a></li> <!-- Enllaç a la pàgina d'inici de sessió -->
            <li>
              <!-- Enllaç a la pàgina del carret de compra -->
              <a href="carret.php" class="carret-compra">
                <!-- Icona del carret en format SVG per millor qualitat i escalabilitat -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <!-- Dibuix vectorial del carret de compra -->
                  <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 3h1l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H6.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H4.21l-.94-2H1v2zm16 15c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
                <!-- Comptador que mostra el número total d'articles al carret -->
                <span class="contador-carret"><?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : '0'; // Calcula la suma total d'articles o mostra 0 si el carret està buit ?></span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- Selector d'idioma amb banderes -->
        <div class="selector-idioma">
                <!-- Enllaç a la versió en català -->
                <a href="index.php"><img class="bandera" src="img/banderacat.png" alt="Català" title="Canviar a català"></a>
                <!-- Enllaç a la versió en anglès -->
                <a href="indexeng.php"><img class="bandera" src="img/banderaeng.svg" alt="English" title="Switch to English"></a>
            </div>
      </div>
    </header>

    <main>
      <section class="seccio_botiga">
        <div class="caixa">
          <h1 class="titol1">Benvingut a la nostra Botiga</h1>
          <p class="text_principal">Descobreix els nostres productes ecològics i artesans creats amb passió i respecte per la natura.</p>

          <div class="categories">
            <a href="Cereals.php" class="categoria">Cereals</a>
            <a href="Herbes.php" class="categoria">Herbes</a>
            <a href="Hortalisses.php" class="categoria">Hortalisses</a>
            <a href="Lactics.php" class="categoria">Làctics</a>
            <a href="Conserves.php" class="categoria">Conserves</a>
            <a href="Fruites.php" class="categoria">Fruites</a>
            <a href="Avicola.php" class="categoria">Avícola</a>
            <a href="Mel.php" class="categoria">Mel</a>
          </div>
 
          <div class="products-grid">
          <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $imagePath = "imgbotiga/" . $row['nom'] . ".png";
                  
                  // Generem l'estructura HTML per cada targeta de producte
                  // Afegim efectes visuals quan el ratolí passa per sobre
                  echo '<div class="product-card" onmouseover="showHoverEffect(this)" onmouseout="removeHoverEffect(this)">';
                  
                  // Contenidor per la imatge del producte
                  echo '<div class="product-image-container">'; // Manté les proporcions i l'estil consistent
                  echo '<img src="' . $imagePath . '" alt="' . $row['nom'] . '" class="product-image">'; // Imatge amb text alternatiu pel nom
                  echo '</div>';
                  
                  // Contenidor per la informació del producte
                  echo '<div class="product-info">'; // Agrupa tota la informació textual
                  echo '<h3>' . $row['nom'] . '</h3>'; // Títol amb el nom del producte
                  echo '<p class="product-type">' . $row['tipus'] . '</p>'; // Categoria o tipus de producte
                  echo '<p class="product-price">' . number_format($row['preu'], 2) . '€/' . $row['unitat'] . '</p>'; // Preu formatat amb 2 decimals
                  echo '<p class="product-stock">Stock: ' . $row['stock'] . ' ' . $row['unitat'] . '</p>'; // Quantitat disponible
                  
                  // Botó per afegir el producte al carret amb els paràmetres necessaris
                  echo '<button onclick="addToCart(' . $row['id_aliment'] . ', \'' . $row['nom'] . '\', ' . $row['preu'] . ')" class="boto_comprar">Afegir al carret</button>';
                  echo '</div>';
                  echo '</div>';
              }
          }
          ?>
          </div>
        </div>
      </section>
    </main>

    <!-- Peu de pàgina amb informació de contacte, horaris i xarxes socials -->
    <footer class="part_inferior"> <!-- Secció inferior de la pàgina amb estils específics pel fons i text -->
      <div class="caixa"> <!-- Contenidor per centrar i limitar l'amplada del contingut del footer -->
        <div class="graella graella_inferior"> <!-- Estructura en graella per organitzar el contingut en columnes -->
          <!-- Primera columna: Logo i adreça -->
          <div class="columna_inferior"> <!-- Columna amb el logo i l'adreça física -->
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" /> <!-- Logo de la granja en versió pel footer -->
            <address> <!-- Element semàntic per marcar la informació de contacte físic -->
              <p> 
                📌 Cami dels Prats, 12<br /> <!-- Adreça física amb icona de localització -->
                Conca d'Odèna <!-- Població -->
              </p> 
            </address>
          </div>
          <!-- Segona columna: Horaris d'obertura -->
          <div class="columna_inferior">
            <h3>Horari</h3> <!-- Títol de la secció d'horaris -->
            <p>Dilluns a Divendres</p> <!-- Dies laborables -->
            <p>9:00 - 14:00 | 16:00 - 19:00</p> <!-- Horari entre setmana -->
            <p>Dissabte</p> <!-- Dies de cap de setmana -->
            <p>9:00 - 14:00</p> <!-- Horari de dissabte -->
          </div>
          <!-- Tercera columna: Informació de contacte i xarxes socials -->
          <div class="columna_inferior"> 
            <h3>Contacte</h3> <!-- Títol de la secció de contacte -->
            <p> 
              <!-- Enllaç de telèfon amb funcionalitat de trucada en dispositius mòbils -->
              📞 <a href="tel:+34999999999" aria-label="Telèfon" title="Trucar al 999 999 999">999 999 999</a><br />
              <!-- Enllaç de correu que obre el client de correu predeterminat -->
              ✉️ <a href="mailto:info@elspratsdor.cat" title="Enviar correu a info@elspratsdor.cat">info@elspratsdor.cat</a>
            </p> 
            <!-- Contenidor per les icones de xarxes socials -->
            <div class="xarxes-socials"> <!-- Flexbox per alinear les icones horitzontalment -->
              <!-- Enllaços a les xarxes socials amb icones -->
              <a href="#" aria-label="Instagram" title="Segueix-nos a Instagram">
                <img src="img/instagram.png" alt="Instagram" /> <!-- Icona d'Instagram -->
              </a>
              <a href="#" aria-label="Facebook" title="Segueix-nos a Facebook">
                <img src="img/facebook.png" alt="Facebook" /> <!-- Icona de Facebook -->
              </a>
              <a href="#" aria-label="Twitter" title="Segueix-nos a Twitter">
                <img src="img/twitter.png" alt="Twitter" /> <!-- Icona de Twitter -->
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
