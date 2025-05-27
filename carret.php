<?php
// Iniciem la sessió per poder mantenir les dades del carret entre diferents pàgines
session_start(); // Aquesta funció crea o recupera la sessió existent

// Comprovem si el carret existeix a la sessió, si no, el creem com un array buit
if (!isset($_SESSION['cart'])) { // Verifica si la variable 'cart' no existeix a la sessió
    $_SESSION['cart'] = array(); // Inicialitza el carret com un array buit
}

// Processem les accions del carret que arriben via POST (afegir o eliminar productes)
if (isset($_POST['action'])) { // Comprova si s'ha enviat una acció via POST
    $response = array(); // Inicialitza l'array de resposta per enviar-lo com a JSON
    
    // Segons l'acció rebuda, executem diferents operacions
    switch ($_POST['action']) {
        case 'add': // Cas per afegir un producte al carret
            // Obtenim les dades del producte des del formulari POST
            $id = $_POST['id']; // ID únic del producte
            $name = $_POST['name']; // Nom del producte
            $price = $_POST['price']; // Preu del producte
            
            // Si el producte no existeix al carret, l'afegim amb quantitat 1
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = array(
                    'name' => $name, // Guardem el nom del producte
                    'price' => $price, // Guardem el preu del producte
                    'quantity' => 1 // Iniciem la quantitat a 1
                );
            } else {
                // Si el producte ja existeix, incrementem la quantitat en 1
                $_SESSION['cart'][$id]['quantity']++;
            }
            
            // Preparem la resposta per al client
            $response['success'] = true; // Indiquem que l'operació ha tingut èxit
            $response['count'] = array_sum(array_column($_SESSION['cart'], 'quantity')); // Calculem el total d'items al carret
            echo json_encode($response); // Convertim la resposta a format JSON i l'enviem
            exit; // Finalitzem l'execució del script
            
        case 'remove': // Cas per eliminar un producte del carret
            $id = $_POST['id']; // Obtenim l'ID del producte a eliminar
            if (isset($_SESSION['cart'][$id])) { // Comprovem si el producte existeix al carret
                unset($_SESSION['cart'][$id]); // Eliminem el producte del carret
            }
            // Preparem la resposta per al client
            $response['success'] = true; // Indiquem que l'operació ha tingut èxit
            $response['count'] = array_sum(array_column($_SESSION['cart'], 'quantity')); // Recalculem el total d'items
            echo json_encode($response); // Convertim la resposta a format JSON i l'enviem
            exit; // Finalitzem l'execució del script
    }
}
?>
<!DOCTYPE html>
<!-- Definim l'idioma principal de la pàgina com a català -->
<html lang="ca">
<head>
    <!-- Definim la codificació de caràcters com a UTF-8 per suportar accents i caràcters especials -->
    <meta charset="UTF-8">
    <!-- Configurem la visualització responsive per a dispositius mòbils -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Títol de la pàgina que es mostra a la pestanya del navegador -->
    <title>Carret de Compra - Els Prats d'Or</title>
    <!-- Preconnexions per optimitzar la càrrega de les fonts de Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Carreguem la font Montserrat amb diferents pesos -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Enllacem els arxius d'estils CSS -->
    <link rel="stylesheet" href="css/style.css">    <link rel="stylesheet" href="css/botiga.css">
    <!-- Carreguem el JavaScript del carret amb l'atribut defer per no bloquejar la càrrega de la pàgina -->
    <script src="js/cart.js" defer></script>
</head>
<body>
    <!-- Capçalera de la pàgina amb la classe part_superior per mantenir-la fixa -->
    <header class="part_superior">
      <!-- Contenidor principal que centra el contingut -->
      <div class="caixa">
        <!-- Enllaç al logo que porta a la pàgina principal -->
        <a href="index.php" class="enllac_logo">
          <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_granja" />
        </a>
        <!-- Menú de navegació principal -->
        <nav class="navegacio">
          <!-- Llista d'elements del menú -->
          <ul class="llista_menu">
            <!-- Elements individuals del menú amb els seus enllaços -->
            <li><a href="index.php" class="element_menu">Inici</a></li>
            <li><a href="botiga.php" class="element_menu">Botiga</a></li>
            <li><a href="formulari.php" class="element_menu">Formulari</a></li>
            <li><a href="login.php" class="boto_accedir">Accedir</a></li>
            <!-- Icona del carret amb el comptador de productes -->
            <li>
              <a href="carret.php" class="carret-compra">
                <!-- Icona SVG del carret de compra -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 3h1l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H6.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H4.21l-.94-2H1v2zm16 15c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
                <!-- Comptador que mostra el número total de productes al carret -->
                <!-- Mostra el número total d'articles al carret, si no n'hi ha mostra 0 -->
                <span class="contador-carret"><?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : '0'; // Calcula la suma total de quantitats o mostra 0 si el carret està buit ?></span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
        <!-- Secció principal que conté tot el contingut del carret -->
        <section class="seccio_carret">
            <div class="caixa">
                <h1>El teu carret</h1>
                <?php if (empty($_SESSION['cart'])): // Comprovem si el carret està buit ?>
                    <!-- Mostrem missatge quan el carret està buit -->
                    <p>El teu carret està buit.</p>
                    <a href="botiga.php" class="boto-tornar">Torna a la botiga</a>
                <?php else: // Si hi ha productes al carret, els mostrem ?>
                    <!-- Contenidor per tots els productes del carret -->
                    <div class="cart-items">
                        <?php
                        // Inicialitzem el total de la compra
                        $total = 0;
                        // Iterem per cada producte al carret
                        foreach ($_SESSION['cart'] as $id => $item):
                            // Calculem el subtotal multiplicant preu per quantitat
                            $subtotal = $item['price'] * $item['quantity'];
                            // Afegim el subtotal al total general
                            $total += $subtotal;
                        ?>
                            <!-- Contenidor individual per cada producte amb el seu ID com a atribut data -->
                            <div class="cart-item" data-id="<?php echo $id; // ID únic del producte ?>">
                                <h3><?php echo $item['name']; // Nom del producte ?></h3>
                                <!-- Informació detallada del producte -->
                                <p class="quantity">Quantitat: <?php echo $item['quantity']; // Quantitat seleccionada ?></p>
                                <p class="price">Preu: <?php echo number_format($item['price'], 2); // Preu formatat amb 2 decimals ?>€</p>
                                <p class="subtotal">Subtotal: <?php echo number_format($subtotal, 2); // Subtotal formatat amb 2 decimals ?>€</p>
                                <!-- Botó per eliminar el producte que crida a la funció JavaScript removeFromCart -->
                                <button class="remove-item" onclick="removeFromCart(<?php echo $id; // Passa l'ID del producte a la funció JS ?>)">Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Mostra el total acumulat de tots els productes -->
                        <div class="cart-total">
                            <h3>Total: <?php echo number_format($total, 2); // Total formatat amb 2 decimals ?>€</h3>
                        </div>
                        <!-- Botons d'acció per continuar comprant o finalitzar la compra -->
                        <div class="cart-actions">
                            <a href="botiga.php" class="boto-tornar">Continua comprant</a>
                            <a href="checkout.php" class="boto-comprar">Finalitza la compra</a>
                        </div>
                    </div>
                <?php endif; // Fi del bloc condicional que mostra el contingut del carret ?>
            </div>
        </section>
    </main>

    <!-- Peu de pàgina amb informació de contacte i xarxes socials -->
    <footer class="part_inferior">
      <!-- Contenidor principal del footer -->
      <div class="caixa">
        <!-- Graella que organitza el contingut en columnes -->
        <div class="graella graella_inferior">
          <!-- Primera columna amb el logo i l'adreça -->
          <div class="columna_inferior">
            <img src="img/LOGO_GRANJA.png" alt="Logo Els Prats d'Or" class="logo_inferior" />
            <!-- Element address per a la informació de localització -->
            <address>
              <p>
                📌 Cami dels Prats, 12<br />
                Conca d'Odèna
              </p>
            </address>
          </div>
          <!-- Segona columna amb l'horari d'obertura -->
          <div class="columna_inferior">
            <h3>Horari</h3>
            <p>Dilluns a Divendres</p>
            <p>9:00 - 20:00</p>
            <p>Dissabtes</p>
            <p>10:00 - 14:00</p>
          </div>
          <!-- Tercera columna amb informació de contacte i xarxes socials -->
          <div class="columna_inferior">
            <h3>Contacte</h3>
            <p>
              <!-- Enllaços de contacte amb icones -->
              📞 <a href="tel:+34999999999">999 999 999</a><br />
              ✉️ <a href="mailto:info@elspratsdor.cat">info@elspratsdor.cat</a>
            </p>
            <!-- Contenidor per les icones de xarxes socials -->
            <div class="xarxes-socials">
              <!-- Enllaços a les xarxes socials amb les seves icones -->
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
        <!-- Text de copyright al peu de pàgina -->
        <div class="text_drets">
          © 2025 Els Prats d'Or. Tots els drets reservats.
        </div>
      </div>
    </footer></body>
</html>