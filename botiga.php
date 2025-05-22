<?php
/* Iniciem la sessió per mantenir el carret entre pàgines */
session_start();

/* Configurem la connexió a la base de dades */
$servername = "127.0.0.1";  // Servidor local
$username = "root";         // Usuari per defecte de XAMPP
$password = "";            // Contrasenya buida per defecte
$dbname = "elspratsdor";   // Nom de la base de dades

/* Creem la connexió utilitzant mysqli */
$conn = new mysqli($servername, $username, $password, $dbname);

/* Comprovem si hi ha hagut algun error en la connexió */
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM aliments ORDER BY tipus";
$result = $conn->query($sql);
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />    <script src="js/botiga.js" defer></script>
    <script src="js/cart.js" defer></script>
    <script src="js/products.js" defer></script>
  </head>
  <body>
    <header class="part_superior"> <!-- 'header' s'utilitza per a la capçalera. La classe 'part_superior' li dóna estils concrets (com fer-la fixa). -->
      <div class="caixa"> <!-- 'caixa' és una classe genèrica per centrar el contingut i limitar el seu ample en diferents seccions. -->
        <a href="index.php" class="enllac_logo"> <!-- Aquest és l'enllaç del logo, que et portarà a la pàgina principal. 'enllac_logo' pot tenir estils específics per l'enllaç del logo. -->
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" /> <!-- 'alt' és important per accessibilitat i SEO. 'logo_granja' s'usa per estilar la imatge del logo. -->
        </a>
        <nav class="navegacio"> <!-- La nostra barra de navegació. 'nav' indica que és una secció de navegació (un menú). -->
          <ul class="llista_menu"> <!-- 'llista_menu' s'usa per estilar la llista d'elements del menú. -->
            <li><a href="index.php" class="element_menu">Inici</a></li> <!-- 'element_menu' s'usa per estilar cada ítem del menú. -->
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
        <div class="selector-idioma">
                <a href="index.php"><img class="bandera" src="img/banderacat.png" alt="Català"></a>
                <a href="indexeng.php"><img class="bandera" src="img/banderaeng.svg" alt="English"></a>
            </div>
      </div>
    </header>

    <main> <!-- 'main' envolta el contingut principal i únic de la pàgina. -->
      <section class="seccio_botiga"> <!-- 'section' s'utilitza per agrupar contingut temàtic. 'seccio_botiga' aplica estils concrets a aquesta secció. -->
        <div class="caixa"> <!-- 'caixa' per centrar el contingut de la secció. -->
          <h1 class="titol1">Benvingut a la nostra Botiga</h1> <!-- 'titol1' per estilar el títol principal de la secció. -->
          <p class="text_principal">Descobreix els nostres productes ecològics i artesans creats amb passió i respecte per la natura.</p> <!-- 'text_principal' per estilar el paràgraf descriptiu. -->

          <!-- AFEGIT: Apartats de categories --> 
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
 
        <!-- Graella de Productes -->
        <div class="products-grid">
          <?php
          if ($result->num_rows > 0) { 
              while($row = $result->fetch_assoc()) {                  $imagePath = 'imgbotiga/' . $row['nom'] . '.png';

                  echo '<div class="product-card" onmouseover="showHoverEffect(this)" onmouseout="removeHoverEffect(this)">';//Exercici 2 Practica 10
                  echo '<div class="product-image-container">';
                  echo '<img src="' . $imagePath . '" alt="' . $row['nom'] . '" class="product-image">';//Imatges mostrades dinamicament, exercici 1 Practica 10
                  echo '</div>';                  echo '<div class="product-info">';
                  echo '<h3>' . $row['nom'] . '</h3>';
                  echo '<p class="product-type">' . $row['tipus'] . '</p>';
                  echo '<p class="product-price">' . number_format($row['preu'], 2) . '€/' . $row['unitat'] . '</p>';
                  echo '<p class="product-stock">Stock: ' . $row['stock'] . ' ' . $row['unitat'] . '</p>';
                  echo '<button onclick="addToCart(' . $row['id_aliment'] . ', \'' . $row['nom'] . '\', ' . $row['preu'] . ')" class="boto_comprar">Afegir al carret</button>';
                  echo '</div>';
                  echo '</div>';
              }
          }
          $conn->close();
          ?>
        </div>
      </section>
    </main>

    <footer class="part_inferior"> <!-- 'footer' s'utilitza per al peu de pàgina. 'part_inferior' aplica estils concrets (fons, color text). -->
      <div class="caixa"> <!-- 'caixa' per centrar el contingut del peu de pàgina. -->
        <div class="graella graella_inferior"> <!-- Una graella per ordenar la informació del peu de pàgina. 'graella' i 'graella_inferior' per estilar la disposició. -->
          <div class="columna_inferior"> <!-- Una columna dins la graella, pel nostre logo i adreça. 'columna_inferior' per estilar la columna. -->
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" /> <!-- El logo que tenim al peu de pàgina. 'logo_inferior' per estilar-lo. -->
            <address> <!-- 'address' és un element per a informació de contacte. -->
              <p> 
                📌 Cami dels Prats, 12<br /> <!-- 'br' insereix un salt de línia. -->
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
              📞 <a href="tel:+34999999999" aria-label="Telèfon">999 999 999</a><br /> <!-- 'href="tel:..."' fa que, en dispositius mòbils, clicar el número truqui directament. 'aria-label' és per a l'accessibilitat. -->
              ✉️ <a href="mailto:info@elspratsdor.cat">info@elspratsdor.cat</a> <!-- 'href="mailto:..."' obre el client de correu electrònic. -->
            </p> 
            <div class="xarxes-socials"> <!-- Un contenidor per les icones de les xarxes socials. 'xarxes-socials' per estilar-lo amb Flexbox. -->
              <a href="#" aria-label="Instagram"> <!-- Enllaços a les xarxes socials, sense destinació perquè no s'han demanat. 'aria-label' per accessibilitat. -->
                <img src="img/instagram.png" alt="Instagram" /> <!-- La imatge de la icona d'instagram. -->
              </a>
              <a href="#" aria-label="Facebook">
                <img src="img/facebook.png" alt="Facebook" />
              </a>
              <a href="#" aria-label="Twitter">
                <img src="img/twitter.png" alt="Twitter" />
              </a>
