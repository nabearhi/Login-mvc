<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Carrito</title>
  <link rel="stylesheet" href="/css/cart.css">
</head>
<body>
  <header>
    <nav>
      <a href="/inicio" class="register-button">Volver a productos</a>
    </nav>
    </header>
    <h1>Tu Carrito</h1>
    <main>
      <?php if (!empty($cart)): ?>
        <table>
          <thead>
            <tr>
              <th>Producto</th>
              <th>Precio</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td>
                  <form method="post" action="/cart/remove" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" class="action-button action-delete">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <form method="post" action="/cart/clear">
          <button type="submit" class="action-button action-clear">Vaciar Carrito</button>
        </form>
      <?php else: ?>
        <p>Tu carrito está vacío.</p>
      <?php endif; ?>
    </main>
</body>
</html>