<?php
session_start(); // Iniciem la sessió per gestionar el carret de la compra

// Configuració de la connexió a la base de dades
$servername = "127.0.0.1"; // Servidor local
$username = "root"; // Usuari de la base de dades
$password = ""; // Contrasenya (buida en desenvolupament local)
$dbname = "elspratsdor"; // Nom de la base de dades

// Establim la connexió amb la base de dades
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprovem si hi ha hagut algun error en la connexió
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Si hi ha error, aturem l'execució
}
?>
<!DOCTYPE html>
<html lang="ca"> <!-- Document HTML en català -->
<head>
    <meta charset="UTF-8" /> <!-- Codificació de caràcters -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> <!-- Configuració responsive -->
    <meta name="description" content="Bibliografia de fonts utilitzades per a la web d'Els Prats d'Or." /> <!-- Descripció per SEO -->
    <title>Els Prats d'Or - Bibliografia</title> <!-- Títol de la pàgina -->
    <link rel="stylesheet" href="css/style.css" /> <!-- Estils generals -->
    <link rel="stylesheet" href="css/bibliografia.css" /> <!-- Estils específics de bibliografia -->
    <link rel="preconnect" href="https://fonts.googleapis.com" /> <!-- Preconnexió a Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> <!-- Preconnexió amb crossorigin -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" /> <!-- Càrrega de fonts -->
</head>
<body>
    <header class="part_superior"> <!-- Capçalera de la pàgina -->
      <div class="caixa"> <!-- Contenidor principal -->
        <a href="index.php" class="enllac_logo"> <!-- Enllaç al logo -->
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" /> <!-- Logo de la granja -->
        </a>
        <nav class="navegacio"> <!-- Menú de navegació -->
          <ul class="llista_menu"> <!-- Llista d'elements del menú -->
            <li><a href="index.php" class="element_menu">Inici</a></li> <!-- Enllaç a la pàgina principal -->
            <li><a href="botiga.php" class="element_menu">Botiga</a></li> <!-- Enllaç a la botiga -->
            <li><a href="formulari.php" class="element_menu">Formulari</a></li> <!-- Enllaç al formulari -->
            <li><a href="login.php" class="boto_accedir">Accedir</a></li> <!-- Botó d'accés -->
            <li>
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
        <h1>Bibliografia</h1> <!-- Títol de la pàgina -->
        <dl> <!-- Llista de definicions per a la bibliografia -->
            <dt>Eina d'ajuda per a mostrar imatges dinamicament: GeeksForGeeks</dt> <!-- Títol de la referència -->
            <dd>Plataforma: Guia HTML / PHP</dd> <!-- Font de la referència -->
            <dd>Enllaç: <a href="https://www.geeksforgeeks.org/how-to-echo-html-in-php/" target="_blank"><abbr title="Uniform Resource Locator">URL</abbr></a></dd> <!-- Enllaç extern -->
        
            <dt>Eina d'Intel·ligència Artificial: Chatgpt</dt> <!-- Títol de la referència -->
            <dd>Plataforma: Open AI</dd> <!-- Font de la referència -->
            <dd>Enllaç: <a href="https://openai.com/es-ES/index/chatgpt/" target="_blank"><abbr title="Uniform Resource Locator">URL</abbr></a></dd> <!-- Enllaç extern -->
            
            <dt>Eina d'Intel·ligència Artificial: GitHub Copilot</dt> <!-- Títol de la referència -->
            <dd>Plataforma: GitHub / Microsoft</dd> <!-- Font de la referència -->
            <dd>Enllaç: <a href="https://github.com/features/copilot" target="_blank"><abbr title="Uniform Resource Locator">URL</abbr></a></dd> <!-- Enllaç extern -->
            
            <dt>Tipografies: Google Fonts</dt> <!-- Títol de la referència -->
            <dd>Plataforma: Google</dd> <!-- Font de la referència -->
            <dd>Enllaç: <a href="https://fonts.google.com/" target="_blank"><abbr title="Uniform Resource Locator">URL</abbr></a></dd> <!-- Enllaç extern -->
            
            <dt>Eina de Traducció: Google Translate</dt> <!-- Títol de la referència -->
            <dd>Plataforma: Google</dd> <!-- Font de la referència -->
            <dd>Enllaç: <a href="https://translate.google.com/" target="_blank"><abbr title="Uniform Resource Locator">URL</abbr></a></dd> <!-- Enllaç extern -->
        </dl>
    </main>

    <footer class="part_inferior"> <!-- Peu de pàgina -->
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
</body>
</html>
