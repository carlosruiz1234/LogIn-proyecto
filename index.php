<?php


session_start(); 

$errores = [];

// ¿Se envió el formulario?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre     = trim($_POST['nombre']     ?? '');
    $gmail      = trim($_POST['gmail']      ?? '');
    $contrasena = $_POST['contrasena']      ?? '';
    $confirmar  = $_POST['confirmar']       ?? '';

    // Validaciones
    if ($nombre === '') {
        $errores['nombre'] = 'El nombre no puede estar vacío.';
    }
    if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($gmail, '@gmail.com')) {
        $errores['gmail'] = 'Ingresa un correo Gmail válido (@gmail.com).';
    }
    if (strlen($contrasena) < 6) {
        $errores['contrasena'] = 'La contraseña debe tener al menos 6 caracteres.';
    }
    if ($contrasena !== $confirmar) {
        $errores['confirmar'] = 'Las contraseñas no coinciden.';
    }

    // Si no hay errores → guardar en sesión
    if (empty($errores)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['gmail']  = $gmail;
        $_SESSION['hora']   = date('d/m/Y H:i:s');
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Stage — Sesión</title>

</head>
<body>

  <!-- IMAGEN -->
  <div class="imagen-lado">
    <span></span>
    <p>STAGE</p>
  </div>

  <!-- FORMULARIO -->
  <div class="formulario-lado">
    <div class="caja-form">

      <h2>Crear cuenta</h2>
      <span class="etiqueta">🔵 stage — sesión PHP</span>

      <!-- Si ya hay sesión activa, mostrar aviso -->
      <?php if (isset($_SESSION['nombre'])): ?>
        <div class="sesion-activa">
           Sesión activa: <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>
        </div>
      <?php endif; ?>

      <form method="POST" action="">

        <!-- CAMPO 1: Nombre -->
        <label for="nombre">Nombre completo</label>
        <input
          type="text" id="nombre" name="nombre"
          placeholder="Ej: Juan Pérez"
          value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
          class="<?= isset($errores['nombre']) ? 'error' : '' ?>"
        >
        <?php if (isset($errores['nombre'])): ?>
          <span class="msg-error">⚠ <?= $errores['nombre'] ?></span>
        <?php endif; ?>

        <!-- CAMPO 2: Gmail -->
        <label for="gmail">Gmail</label>
        <input
          type="email" id="gmail" name="gmail"
          placeholder="Ej: juan@gmail.com"
          value="<?= htmlspecialchars($_POST['gmail'] ?? '') ?>"
          class="<?= isset($errores['gmail']) ? 'error' : '' ?>"
        >
        <?php if (isset($errores['gmail'])): ?>
          <span class="msg-error">⚠ <?= $errores['gmail'] ?></span>
        <?php endif; ?>

        <!-- CAMPO 3: Contraseña -->
        <label for="contrasena">Contraseña</label>
        <input
          type="password" id="contrasena" name="contrasena"
          placeholder="Mínimo 6 caracteres"
          class="<?= isset($errores['contrasena']) ? 'error' : '' ?>"
        >
        <?php if (isset($errores['contrasena'])): ?>
          <span class="msg-error">⚠ <?= $errores['contrasena'] ?></span>
        <?php endif; ?>

        <!-- CAMPO 4: Confirmar contraseña -->
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

      <!-- DATOS MOSTRADOS SI HAY SESIÓN -->
      <?php if (isset($_SESSION['nombre'])): ?>
        <div class="datos-ok">
          <h3>✅ Sesión iniciada</h3>
          <p><strong>Nombre:</strong> <?= htmlspecialchars($_SESSION['nombre']) ?></p>
          <p><strong>Gmail:</strong>  <?= htmlspecialchars($_SESSION['gmail']) ?></p>
          <p><strong>Contraseña:</strong> ••••••</p>
          <p><strong>Hora de registro:</strong> <?= $_SESSION['hora'] ?></p>
          <p style="margin-top:8px;font-size:12px;color:#888;">
            💾 Guardado en <code>$_SESSION</code> de PHP
          </p>
          <!-- Botón cerrar sesión → va a logout.php -->
          <form method="POST" action="logout.php">
            <button class="btn-cerrar" type="submit"> Cerrar sesión</button>
          </form>
        </div>
      <?php endif; ?>

    </div>
  </div>

</body>
</html>
