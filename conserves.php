<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "elspratsdor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM aliments WHERE tipus = 'Conserva' ORDER BY nom";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Botiga online amb productes ecològics i artesans de la granja Els Prats d'Or - Conserves" />
    <title>Conserves - Els Prats d'Or</title>
    <link rel="stylesheet" href="css/aliments.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <script src="js/cart.js" defer></script>
    <script src="js/products.js" defer></script>
    <script src="js/botiga.js" defer></script>

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
      <section class="seccio_botiga">
        <div class="caixa">
          <h1 class="titol1">Conserves</h1>
          <p class="text_principal">Descobreix les nostres conserves artesanals elaborades amb productes frescos de la granja.</p>
          <a href="botiga.php" class="boto-tornar">← Tornar a la botiga</a>
        </div>

        <div class="categories">
          <a href="cereals.php" class="categoria">Cereals</a>
          <a href="herbes.php" class="categoria">Herbes</a>
          <a href="hortalisses.php" class="categoria">Hortalisses</a>
          <a href="lactics.php" class="categoria">Làctics</a>
          <a href="fruites.php" class="categoria">Fruites</a>
          <a href="avicola.php" class="categoria">Avícola</a>
          <a href="mel.php" class="categoria">Mel</a>
        </div>

        <div class="products-grid">
          <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $imagePath = 'imgbotiga/' . $row['nom'] . '.png';

                  echo '<div class="product-card" onmouseover="showHoverEffect(this)" onmouseout="removeHoverEffect(this)">';
                  echo '<div class="product-image-container">';
                  echo '<img src="' . $imagePath . '" alt="' . $row['nom'] . '" class="product-image">';
                  echo '</div>';
                  echo '<div class="product-info">';
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

    <footer class="part_inferior">
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
    </footer>  </body>
</html>