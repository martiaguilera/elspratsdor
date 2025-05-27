<?php
// Iniciem la sessió per mantenir l'estat de l'usuari entre pàgines
session_start();

// Configuració de la connexió a la base de dades MySQL
$servername = "localhost"; // Servidor de la base de dades
$username = "root";     // Nom d'usuari de la base de dades
$password = "";         // Contrasenya de la base de dades
$dbname = "elspratsdor"; // Nom de la base de dades

// Establim la connexió amb la base de dades utilitzant mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprovem si hi ha hagut algun error en la connexió
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Si hi ha error, aturem l'execució
}
?>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> <!-- Important per al disseny responsive en mòbils i tauletes. Controla com es mostra l'ample i l'escala de la pàgina. -->
    <meta name="description" content="Granja ecològica familiar a la Conca d'Odèna. Productes naturals i artesans amb tradició des de 1985." /> <!-- Aquesta descripció la poden utilitzar els cercadors en els resultats. -->
    <title>Els Prats d'Or - Inici</title>
    <link rel="stylesheet" href="css/style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" /> <!-- Ajuda a carregar les fonts de Google Fonts més ràpid preparant la connexió. -->
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> <!-- Complementa el preconnect per a fonts. 'crossorigin' és per temes de seguretat en carregar recursos de llocs externs. -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" /> <!-- Enllaç a Google Fonts per carregar fonts específiques amb diferents gruixos (pesos de lletra) i 'display=swap' per a com es gestiona la càrrega de la font. -->
  </head>
  <body>
    <header class="part_superior"> <!-- 'header' s'utilitza per a la capçalera. La classe 'part_superior' li dóna estils concrets (com fer-la fixa). -->
      <div class="caixa"> <!-- 'caixa' és una classe genèrica per centrar el contingut i limitar el seu ample en diferents seccions. -->
        <a href="index.php" class="enllac_logo"> <!-- 'enllac_logo' pot tenir estils específics per l'enllaç del logo. -->
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" /> <!-- 'alt' és important per accessibilitat i SEO. 'logo_granja' s'usa per estilar la imatge del logo. -->
        </a>
        <nav class="navegacio"> <!-- 'nav' indica que és una secció de navegació (un menú). -->
          <ul class="llista_menu"> <!-- 'llista_menu' s'usa per estilar la llista d'elements del menú. -->
            <li><a href="index.php" class="element_menu">Inici</a></li> <!-- 'element_menu' s'usa per estilar cada ítem del menú, inclòs l'efecte de subratllat amb CSS. -->
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
        <div class="selector-idioma"> <!-- Contenidor per a les opcions de canvi d'idioma. La classe 'selector-idioma' s'usa per posicionar-lo (normalment a dalt a la dreta) i estilar les banderes. -->
          <a href="index.php"><img class="bandera" src="img/banderacat.png" alt="Català" /></a> <!-- 'bandera' s'usa per estilar les imatges de les banderes. El 'src' està buit, hauria de tenir la ruta de la imatge. -->
          <a href="indexeng.php"><img class="bandera" src="img/banderaeng.svg" alt="Anglès" /></a>
        </div>
      </div>
    </header>
    <main> <!-- 'main' envolta el contingut principal i únic de la pàgina. -->
      <section class="seccio_principal"> <!-- 'section' s'utilitza per agrupar contingut temàtic. 'seccio_principal' li dóna estils de fons (vídeo), alçada i centrat. -->
        <video autoplay muted loop playsinline id="video_fons"> <!-- 'autoplay', 'muted', 'loop' i 'playsinline' són atributs per controlar la reproducció automàtica, sense so, repetida i dins de la pàgina (especialment en mòbils). 'id="video_fons"' permet referenciar-lo directament amb CSS o JavaScript. -->
          <source src="img/vidlogin.mp4" type="video/mp4" /> <!-- 'source' especifica el fitxer de vídeo i el seu tipus MIME, útil si ofereixes diferents formats de vídeo per compatibilitat amb navegadors. -->
          El teu navegador no admet vídeos HTML5.
        </video>
          <div class="caixa caixa_principal"> <!-- Combina les classes 'caixa' (centrar/ample) i 'caixa_principal' (estils específics per a aquesta caixa de contingut principal: text blanc, centrat, z-index superior). -->
            <h1 class="titol1">Alimentació <span class="text_important">conscient</span> des del 1985</h1> <!-- 'titol1' per estilar el títol principal. 'span' amb 'text_important' per estilar una part concreta del títol (el color destacat). -->
            <p class="text_principal">Productes ecològics criats amb respecte i tradició</p> <!-- 'text_principal' per estilar el paràgraf sota el títol. -->
            <div class="caixa_botons_principal"> <!-- Contenidor per organitzar els botons principals amb Flexbox. -->
              <a href="botiga.php" class="boto_botiga">Descobreix la botiga</a> <!-- 'boto_botiga' li dóna l'aparença del botó primari amb fons taronja. -->
              <a href="#proces" class="boto_info">Més informació ↓</a> <!-- 'href="#proces"' crea un enllaç intern a l'element amb l'ID 'proces'. 'boto_info' li dóna l'aparença del botó secundari amb vora. -->
            </div>
          </div>
          <div class="fons_transparent"></div> <!-- 'fons_transparent' és un 'div' sense contingut visible, usat per crear una capa semitransparent sobre el vídeo mitjançant CSS. -->
        </section>
        <section id="proces" class="seccio_proces"> <!-- 'id="proces"' permet enllaçar directament a aquesta secció. 'seccio_proces' aplica estils de fons i espaiat. -->
          <div class="caixa">
            <h2 class="titol2">El nostre <span class="text_subratllat">procés</span></h2> <!-- 'titol2' per estilar els títols secundaris. 'span' amb 'text_subratllat' per aplicar un subratllat estilitzat a una part del títol. -->
            <div class="graella graella_proces"> <!-- 'graella' i 'graella_proces' s'utilitzen per crear una disposició en graella amb CSS Grid per a les caixes del procés. -->
              <article class="caixa_proces"> <!-- 'article' és un element per a contingut independent. 'caixa_proces' s'usa per estilar cada caixa individual del procés. -->
                <div class="numero_proces">1</div> <!-- 'numero_proces' s'usa per estilar el cercle numerat de cada pas. -->
                <h3>Criança natural</h3>
                <p>Animals criats seguint els seus ritmes naturals.</p>
              </article>
              <article class="caixa_proces">
                <div class="numero_proces">2</div>
                <h3>Transformació artesanal</h3>
                <p>Elaboració manual sense processos industrials.</p>
              </article>
              <article class="caixa_proces">
                <div class="numero_proces">3</div>
                <h3>Distribució directa</h3>
                <p>De la nostra granja a la teva taula en 24h.</p>
              </article>
            </div>
          </div>
        </section>
        <section class="seccio_imatges"> <!-- 'seccio_imatges' aplica estils de fons i espaiat a aquesta secció. -->
          <div class="caixa">
            <h2 class="titol2">La nostra <span class="text_subratllat">realitat</span></h2> <!-- 'text_subratllat' per estilar una part del títol. -->
            <div class="graella graella_imatges"> <!-- 'graella' i 'graella_imatges' s'utilitzen per crear una disposició en graella per a les imatges amb CSS Grid. -->
              <figure class="caixa_imatge"> <!-- 'figure' és per a contingut autònom, sovint imatges. 'caixa_imatge' s'usa per estilar cada contenidor d'imatge (cantonades, ombra, efecte hover). -->
                <img src="img/granja_animals.png" alt="Animals a la granja en plena llibertat" /> <!-- 'alt' és important per accessibilitat i SEO. -->
              </figure>
              <figure class="caixa_imatge">
                <img src="img/camps_farratge_blat.png" alt="Camps de cultiu de cereals i farratges" />
              </figure>
              <figure class="caixa_imatge">
                <img src="img/productes_frescos.png" alt="Taula amb diversos productes frescos" />
              </figure>
            </div>
          </div>
        </section>
      </main>
      <footer class="part_inferior" id="contacte"> <!-- 'footer' s'utilitza per al peu de pàgina. 'part_inferior' aplica estils concrets (fons, color text). 'id="contacte"' permet enllaçar directament a aquesta secció des d'altres llocs. -->
        <div class="caixa">
          <div class="graella graella_inferior"> <!-- 'graella' i 'graella_inferior' s'utilitzen per organitzar les columnes d'informació del peu de pàgina en una graella adaptable. -->
            <div class="columna_inferior"> <!-- 'columna_inferior' s'usa per estilar cada columna de contingut al peu de pàgina. -->
              <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" /> <!-- 'logo_inferior' s'usa per estilar el logo al peu de pàgina. -->
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
                📞 <a href="tel:+34999999999" aria-label="Telèfon">999 999 999</a><br /> <!-- 'href="tel:..."' fa que, en dispositius mòbils, clicar el número truqui directament. 'aria-label' és per a l'accessibilitat, proporciona una descripció addicional per a lectors de pantalla. -->
                ✉️ <a href="mailto:info@elspratsdor.cat">info@elspratsdor.cat</a> <!-- 'href="mailto:..."' obre el client de correu electrònic de l'usuari amb l'adreça pre-omplerta. -->
              </p>
              <div class="xarxes-socials"> <!-- 'xarxes-socials' conté i estila les icones de les xarxes socials amb Flexbox. -->
                <a href="#" aria-label="Instagram"> <!-- 'href="#"' és un enllaç buit, hauria d'apuntar al perfil d'Instagram. 'aria-label' per accessibilitat. -->
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
          <div class="text_drets"> <!-- 'text_drets' s'usa per estilar el text de copyright al final del peu de pàgina. -->
            &copy; 2025 Els Prats d'Or. Tots els drets reservats. <!-- '&copy;' és una entitat HTML per mostrar el símbol de copyright (©). -->
          </div>
            <div class="text_drets">
              <a href="bibliografia.php">Bibliografia</a>
            </div>
            <div class="text_drets">
              <a href="consultes.php">Consultes</a>
            </div>
        </div>
      </footer>
    </body>
  </html>
