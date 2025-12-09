<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="/css/login.css"> 
</head>
<body>
  <div class="login-container"> 
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="/login" autocomplete="off">
      <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input id="email" name="email" type="email" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password"
               pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{6,}$"
               title="Debe incluir letras, números y símbolos, mínimo 6 caracteres"
               required>
      </div>
      <button type="submit">Entrar</button>
    </form>
    <div class="register-link">
      <p>¿No tienes cuenta?</p>
      <a href="/register" class="register-button">Registrarse</a>
    </div>
  </div>
</body>
</html>
