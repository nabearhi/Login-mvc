<?php $error = $error ?? null; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registrarse</title>
  <link rel="stylesheet" href="/css/register.css">
</head>
<body>
  <div class="register-container">
    <h1>Registrarse</h1>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="/register" autocomplete="off">
      <div class="form-group">
        <label for="email">Correo</label>
        <input id="email" name="email" type="email" required>
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="text" pattern="[0-9]{10}" 
               title="Debe contener exactamente 10 dígitos" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password" 
               pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{6,}$"
               title="Debe incluir letras, números y símbolos, mínimo 6 caracteres" required>
      </div>

      <button type="submit">Registrarse</button>
    </form>
    <div id="popup" style="display:none;">
  <p>¡Registro exitoso! Revisa tu correo para validar tu cuenta.</p>
</div>
<script>
  function showPopup() {
    document.getElementById("popup").style.display = "block";
  }
</script>

    <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
  </div>
</body>
</html>
