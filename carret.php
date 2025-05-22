<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['action'])) {
    $response = array();
    
    switch ($_POST['action']) {
        case 'add':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = array(
                    'name' => $name,
                    'price' => $price,
                    'quantity' => 1
                );
            } else {
                $_SESSION['cart'][$id]['quantity']++;
            }
            
            $response['success'] = true;
            $response['count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));
            echo json_encode($response);
            exit;
            
        case 'remove':
            $id = $_POST['id'];
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }
            $response['success'] = true;
            $response['count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));
            echo json_encode($response);
            exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carret de Compra - Els Prats d'Or</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">    <link rel="stylesheet" href="css/botiga.css">
    <script src="js/cart.js" defer></script>
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
        <section class="seccio_carret">
            <div class="caixa">
                <h1>El teu carret</h1>
                <?php if (empty($_SESSION['cart'])): ?>
                    <p>El teu carret està buit.</p>
                    <a href="botiga.php" class="boto-tornar">Torna a la botiga</a>
                <?php else: ?>
                    <div class="cart-items">
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $id => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <div class="cart-item" data-id="<?php echo $id; ?>">
                                <h3><?php echo $item['name']; ?></h3>
                                <p class="quantity">Quantitat: <?php echo $item['quantity']; ?></p>
                                <p class="price">Preu: <?php echo number_format($item['price'], 2); ?>€</p>
                                <p class="subtotal">Subtotal: <?php echo number_format($subtotal, 2); ?>€</p>
                                <button class="remove-item" onclick="removeFromCart(<?php echo $id; ?>)">Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="cart-total">
                            <h3>Total: <?php echo number_format($total, 2); ?>€</h3>
                        </div>
                        
                        <div class="cart-actions">
                            <a href="botiga.php" class="boto-tornar">Continuar comprant</a>
                            <button class="boto-pagar" disabled>Procedir al pagament</button>
                        </div>
                    </div>
                <?php endif; ?>
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
            <p>9:00 - 20:00</p>
            <p>Dissabtes</p>
            <p>10:00 - 14:00</p>
          </div>
          <div class="columna_inferior">
            <h3>Contacte</h3>
            <p>
              📞 <a href="tel:+34999999999">999 999 999</a><br />
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
          © 2025 Els Prats d'Or. Tots els drets reservats.
        </div>
      </div>
    </footer></body>
</html>