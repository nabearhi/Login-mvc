<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio</title>
  <link rel="stylesheet" href="/css/inicio.css">
</head>
<body>
  <header>
    <nav>
      <span>Hola, <?= htmlspecialchars($user['email']) ?> (<?= htmlspecialchars($user['role']) ?>)</span>
      <form method="post" action="/logout" style="display:inline;">
        <button type="submit" class="action-button">Cerrar sesión</button>
      </form>

      <div class="cart-icon" onclick="document.getElementById('cart-modal').classList.add('open')">
        🛒
        <span id="cart-count" class="cart-count">
          <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
        </span>
      </div>
    </nav>
  </header>

  <h1>Productos</h1>
  <main>
    <div class="productos">
      <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
          <div class="producto">
            <?php if (!empty($producto['imagen'])): ?>
              <img src="/public/img/<?= htmlspecialchars($producto['imagen']) ?>" 
                   alt="<?= htmlspecialchars($producto['nombre']) ?>" width="120">
            <?php else: ?>
              <img src="/public/img/default.png" alt="Sin imagen" width="120">
            <?php endif; ?>

            <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
            <p><?= htmlspecialchars($producto['descripcion']) ?></p>
            <span class="precio">$<?= number_format($producto['precio'], 2) ?></span>

            <!-- Botón agregar al carrito -->
            <form method="post" action="/cart/add" style="display:inline;">
              <input type="hidden" name="id" value="<?= $producto['id'] ?>">
              <button type="submit" class="action-button action-cart">Agregar al carrito</button>
            </form>

            <?php if ($user['role'] === 'admin'): ?>
              <form method="post" action="/admin/deleteProduct" style="display:inline;">
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                <button type="submit" class="action-button action-delete">Eliminar</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay productos disponibles.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- Modal del carrito -->
  <div id="cart-modal" class="cart-modal <?= !empty($_SESSION['open_cart_modal']) ? 'open' : '' ?>">
    <div class="cart-header">
      <h2>Carrito</h2>
      <button onclick="document.getElementById('cart-modal').classList.remove('open')" class="close-cart">✖</button>
    </div>
    <ul class="cart-items">
      <?php 
      $total = 0;
      if (!empty($_SESSION['cart'])):
        foreach ($_SESSION['cart'] as $item):
          $total += $item['precio']; ?>
          <li>
            <span><?= htmlspecialchars($item['nombre']) ?> - $<?= number_format($item['precio'], 2) ?></span>
            <form method="post" action="/cart/remove" style="display:inline;">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="action-button action-delete">Eliminar</button>
            </form>
          </li>
        <?php endforeach;
      else: ?>
        <p>Tu carrito está vacío.</p>
      <?php endif; ?>
    </ul>
    <div class="cart-total">Total: $<?= number_format($total, 2) ?></div>

    <?php if (!empty($_SESSION['cart'])): ?>
      <form method="post" action="/cart/clear" style="margin-top:1rem;">
        <button type="submit" class="action-button action-clear">Vaciar carrito</button>
      </form>
    <?php endif; ?>
  </div>

  <?php unset($_SESSION['open_cart_modal']); ?>
</body>
</html>
