<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
  <header>
    <h1>Bienvenido Administrador</h1>
    <nav>
      <span><?= htmlspecialchars($user['email']) ?> (<?= htmlspecialchars($user['role']) ?>)</span>
      <form method="post" action="/logout" style="display:inline;">
        <button type="submit">Cerrar sesión</button>
      </form>
    </nav>
  </header>

  <main>

    <h2>Usuarios registrados</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Rol</th>
        <th>Activo</th>
        <th>Acciones</th>
      </tr>

      <?php if (!empty($users)): ?>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['telefono']) ?></td>
          <td><?= htmlspecialchars($u['role']) ?></td>
          <td><?= $u['is_active'] ? 'Sí' : 'No' ?></td>
          <td>
            <form method="post" action="/admin/changeRole" style="display:inline;">
              <input type="hidden" name="id" value="<?= $u['id'] ?>">
              <select name="role">
                <option value="user" <?= $u['role']==='user'?'selected':'' ?>>Usuario</option>
                <option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>Administrador</option>
              </select>
              <button type="submit" class="action-button action-edit">Actualizar</button>
            </form>

            <form method="post" action="/admin/deleteUser" style="display:inline;">
              <input type="hidden" name="id" value="<?= $u['id'] ?>">
              <button type="submit" class="action-button action-delete">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6">No hay usuarios registrados</td></tr>
      <?php endif; ?>
    </table>

  <h2>Productos existentes</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Descripción</th>
    <th>Precio</th>
    <th>Imagen</th>
    <th>Acciones</th>
  </tr>

  <?php if (!empty($productos)): ?>
    <?php foreach ($productos as $producto): ?>
    <tr>
      <td><?= $producto['id'] ?></td>
      <td><?= htmlspecialchars($producto['nombre']) ?></td>
      <td><?= htmlspecialchars($producto['descripcion']) ?></td>
      <td>$<?= number_format($producto['precio'], 2) ?></td>
      <td>
        <?php if (!empty($producto['imagen'])): ?>
          <img src="/public/img/ htmlspecialchars($producto['imagen']) ?>" width="60" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <?php else: ?>
          Sin imagen
        <?php endif; ?>
      </td>
      <td>
        <form method="get" action="/admin/editProduct" style="display:inline;">
          <input type="hidden" name="id" value="<?= $producto['id'] ?>">
          <button type="submit" class="action-button action-edit">Editar</button>
        </form>
        <form method="post" action="/admin/deleteProduct" style="display:inline;">
          <input type="hidden" name="id" value="<?= $producto['id'] ?>">
          <button type="submit" class="action-button action-delete">Eliminar</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="6">No hay productos registrados</td></tr>
  <?php endif; ?>
</table>

<h2>Agregar producto</h2>
    <form method="post" action="/admin/addProduct" class="form-producto" enctype="multipart/form-data">
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="descripcion">Descripción:</label>
      <textarea id="descripcion" name="descripcion"></textarea>

      <label for="precio">Precio:</label>
      <input type="number" id="precio" step="0.01" name="precio" required>

      <label for="imagen">Imagen:</label>
      <input type="file" id="imagen" name="imagen" accept="image/*" required>

      <button type="submit" class="action-button action-save">Guardar</button>
    </form>


  </main>
</body>
</html>
