<?php
session_start();
require 'db.php'; // conexión a MySQL


$errores = $_SESSION['errores'] ?? [];
$form    = $_SESSION['form']    ?? [];


unset($_SESSION['errores'], $_SESSION['form']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Log In</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>


  <div class="imagen-lado">
  </div>


  <div class="formulario-lado">
    <div class="caja-form">

      <h2>Crear cuenta</h2>



      <?php if (isset($_SESSION['nombre'])): ?>
        <div class="sesion-activa">
           Sesión activa: <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>
        </div>
      <?php endif; ?>

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
          <span class="msg-error"> <?= $errores['gmail'] ?></span>
        <?php endif; ?>

        <!-- CONTRASEÑA -->
        <label for="contrasena">Contraseña</label>
        <input
          type="password" id="contrasena" name="contrasena"
          placeholder="Mínimo 6 caracteres"
          class="<?= isset($errores['contrasena']) ? 'error' : '' ?>"
        >
        <?php if (isset($errores['contrasena'])): ?>
          <span class="msg-error"> <?= $errores['contrasena'] ?></span>
        <?php endif; ?>

        <!-- CONFIRMAR -->
        <label for="confirmar">Confirmar contraseña</label>
        <input
          type="password" id="confirmar" name="confirmar"
          placeholder="Repite la contraseña"
          class="<?= isset($errores['confirmar']) ? 'error' : '' ?>"
        >
        <?php if (isset($errores['confirmar'])): ?>
          <span class="msg-error"> <?= $errores['confirmar'] ?></span>
        <?php endif; ?>

        <button type="submit">Registrarse</button>

      </form>


      <?php if (isset($_SESSION['nombre'])): ?>
        <div class="datos-ok">
          <h3> Registro exitoso</h3>
          <p><strong>ID en BD:</strong> <?= $_SESSION['id'] ?></p>
          <p><strong>Nombre:</strong> <?= htmlspecialchars($_SESSION['nombre']) ?></p>
          <p><strong>Gmail:</strong> <?= htmlspecialchars($_SESSION['gmail']) ?></p>
          <p><strong>Contraseña:</strong> ••••••</p>
          <p><strong>Hora:</strong> <?= $_SESSION['hora'] ?></p>

          <form method="POST" action="logout.php">
            <button class="btn-cerrar" type="submit"> Cerrar sesión</button>
          </form>
        </div>

      <?php endif; ?>

    </div>
  </div>

</body>
</html>