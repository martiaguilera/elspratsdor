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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Granja ecològica familiar a la Conca d'Odèna. Productes naturals i artesans amb tradició des de 1985." />
    <title>Els Prats d'Or - Home</title>
    <link rel="stylesheet" href="css/style.css" />
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
            <li><a href="indexeng.php" class="element_menu">Home</a></li>
            <li><a href="botiga.php" class="element_menu">Shop</a></li>
            <li><a href="formulari.php" class="element_menu">Form</a></li>
            <li><a href="login.php" class="boto_accedir">Login</a></li>
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
          <a href="index.php"><img class="bandera" src="img/banderacat.png" alt="Català" /></a>
          <a href="indexeng.php"><img class="bandera" src="img/banderaeng.svg" alt="English" /></a>
        </div>
      </div>
    </header>
    <main>
      <section class="seccio_principal">
        <video autoplay muted loop playsinline id="video_fons">
          <source src="img/vidlogin.mp4" type="video/mp4" />
          Your browser does not support HTML5 video.
        </video>
        <div class="caixa caixa_principal">
          <h1 class="titol1">Conscious <span class="text_important">food</span> since 1985</h1>
          <p class="text_principal">Organic products raised with respect and tradition</p>
          <div class="caixa_botons_principal">
            <a href="botiga.php" class="boto_botiga">Discover the shop</a>
            <a href="#proces" class="boto_info">More information ↓</a>
          </div>
        </div>
        <div class="fons_transparent"></div>
      </section>
      <section id="proces" class="seccio_proces">
        <div class="caixa">
          <h2 class="titol2">Our <span class="text_subratllat">process</span></h2>
          <div class="graella graella_proces">
            <article class="caixa_proces">
              <div class="numero_proces">1</div>
              <h3>Natural breeding</h3>
              <p>Animals raised following their natural rhythms.</p>
            </article>
            <article class="caixa_proces">
              <div class="numero_proces">2</div>
              <h3>Artisan transformation</h3>
              <p>Manual elaboration without industrial processes.</p>
            </article>
            <article class="caixa_proces">
              <div class="numero_proces">3</div>
              <h3>Direct distribution</h3>
              <p>From our farm to your table in 24h.</p>
            </article>
          </div>
        </div>
      </section>
      <section class="seccio_imatges">
        <div class="caixa">
          <h2 class="titol2">Our <span class="text_subratllat">reality</span></h2>
          <div class="graella graella_imatges">
            <figure class="caixa_imatge">
              <img src="img/granja_animals.png" alt="Animals on the farm in complete freedom" />
            </figure>
            <figure class="caixa_imatge">
              <img src="img/camps_farratge_blat.png" alt="Fields of cereal and fodder crops" />
            </figure>
            <figure class="caixa_imatge">
              <img src="img/productes_frescos.png" alt="Table with various fresh products" />
            </figure>
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
            <h3>Opening Hours</h3>
            <p>Monday to Friday</p>
            <p>9:00 - 14:00 | 16:00 - 19:00</p>
            <p>Saturday</p>
            <p>9:00 - 14:00</p>
          </div>
          <div class="columna_inferior">
            <h3>Contact</h3>
            <p>
              📞 <a href="tel:+34999999999" aria-label="Phone">999 999 999</a><br />
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
          &copy; 2025 Els Prats d'Or. All rights reserved.
        </div>
      </div>
    </footer>
  </body>
</html>