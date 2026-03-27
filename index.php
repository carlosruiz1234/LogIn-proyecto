<?php
// ── RAMA DEVELOP: sin sesiones, sin base de datos ──
// Las validaciones se hacen en validaciones.php y se pasan por GET

$errores = [];
$form    = [];

// Recibir errores y datos desde validaciones.php via GET
if (!empty($_GET)) {
    if (isset($_GET['err_nombre']))    $errores['nombre']    = htmlspecialchars($_GET['err_nombre']);
    if (isset($_GET['err_gmail']))     $errores['gmail']     = htmlspecialchars($_GET['err_gmail']);
    if (isset($_GET['err_contrasena'])) $errores['contrasena'] = htmlspecialchars($_GET['err_contrasena']);
    if (isset($_GET['err_confirmar'])) $errores['confirmar'] = htmlspecialchars($_GET['err_confirmar']);

    $form['nombre'] = $_GET['nombre'] ?? '';
    $form['gmail']  = $_GET['gmail']  ?? '';
    $exito          = isset($_GET['ok']) && $_GET['ok'] === '1';
} else {
    $exito = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Log In - Develop</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <div class="imagen-lado"></div>

  <div class="formulario-lado">
    <div class="caja-form">

      <h2>Crear cuenta</h2>

      <?php if ($exito): ?>
        <div class="datos-ok">
          <h3>✔ Formulario válido</h3>
          <p>Todos los campos pasaron las validaciones correctamente.</p>
          <p><strong>Nombre:</strong> <?= htmlspecialchars($form['nombre']) ?></p>
          <p><strong>Gmail:</strong> <?= htmlspecialchars($form['gmail']) ?></p>
          <p><strong>Contraseña:</strong> ••••••</p>
          <a href="index.php"><button type="button">Volver</button></a>
        </div>
      <?php else: ?>

        <!-- FORMULARIO -->
        <form method="POST" action="validaciones.php">

          <!-- NOMBRE -->
          <label for="nombre">Nombre completo</label>
          <input
            type="text" id="nombre" name="nombre"
            placeholder="Ej: Juan Pérez"
            value="<?= htmlspecialchars($form['nombre'] ?? '') ?>"
            class="<?= isset($errores['nombre']) ? 'error' : '' ?>"
          >
          <?php if (isset($errores['nombre'])): ?>
            <span class="msg-error">⚠ <?= $errores['nombre'] ?></span>
          <?php endif; ?>

          <!-- GMAIL -->
          <label for="gmail">Gmail</label>
          <input
            type="email" id="gmail" name="gmail"
            placeholder="Ej: juan@gmail.com"
            value="<?= htmlspecialchars($form['gmail'] ?? '') ?>"
            class="<?= isset($errores['gmail']) ? 'error' : '' ?>"
          >
          <?php if (isset($errores['gmail'])): ?>
            <span class="msg-error">⚠ <?= $errores['gmail'] ?></span>
          <?php endif; ?>

          <!-- CONTRASEÑA -->
          <label for="contrasena">Contraseña</label>
          <input
            type="password" id="contrasena" name="contrasena"
            placeholder="Mínimo 6 caracteres"
            class="<?= isset($errores['contrasena']) ? 'error' : '' ?>"
          >
          <?php if (isset($errores['contrasena'])): ?>
            <span class="msg-error">⚠ <?= $errores['contrasena'] ?></span>
          <?php endif; ?>

          <!-- CONFIRMAR -->
          <label for="confirmar">Confirmar contraseña</label>
          <input
            type="password" id="confirmar" name="confirmar"
            placeholder="Repite la contraseña"
            class="<?= isset($errores['confirmar']) ? 'error' : '' ?>"
          >
          <?php if (isset($errores['confirmar'])): ?>
            <span class="msg-error">⚠ <?= $errores['confirmar'] ?></span>
          <?php endif; ?>

          <button type="submit">Registrarse</button>

        </form>

      <?php endif; ?>

    </div>
  </div>

</body>
</html>
