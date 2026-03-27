<?php

session_start();
require 'db.php';

$errores = [];


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombre     = trim($_POST['nombre']     ?? '');
$gmail      = trim($_POST['gmail']      ?? '');
$contrasena = $_POST['contrasena']      ?? '';
$confirmar  = $_POST['confirmar']       ?? '';

// ── Validaciones ──
if ($nombre === '') {
    $errores['nombre'] = 'El nombre no puede estar vacío.';
}
if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
    $errores['err_nombre'] = 'El nombre solo puede contener letras.';
}
if (strlen($nombre) < 3) {
    $errores['err_nombre'] = 'El nombre debe tener al menos 3 caracteres.';
}
if (strlen($nombre) > 50) {
    $errores['err_nombre'] = 'El nombre no puede superar los 50 caracteres.';
}
//___________________________________________
if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($gmail, '@gmail.com')) {
    $errores['gmail'] = 'Ingresa un correo Gmail válido (@gmail.com).';
}
if (str_contains($gmail, ' ')) {
    $errores['err_gmail'] = 'El correo no puede tener espacios.';
}

if (strlen($usuario) < 3) {
    $errores['err_gmail'] = 'El nombre de usuario del correo es muy corto.';
}
//______________________________________________
if (strlen($contrasena) < 6) {
    $errores['contrasena'] = 'La contraseña debe tener al menos 6 caracteres.';
}
if (!preg_match('/[\W_]/', $contrasena)) {
    $errores['err_contrasena'] = 'Debe tener al menos un símbolo (!, @, #...).';
}
if (strlen($contrasena) > 30) {
    $errores['err_contrasena'] = 'La contraseña no puede superar los 30 caracteres.';
}
//______________________________________________
if ($contrasena !== $confirmar) {
    $errores['confirmar'] = 'Las contraseñas no coinciden.';
}


if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['form']    = ['nombre' => $nombre, 'gmail' => $gmail];
    header('Location: index.php');
    exit;
}

$contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);


$sql  = "INSERT INTO usuarios (nombre, gmail, contrasena) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('sss', $nombre, $gmail, $contrasena_encriptada);

if ($stmt->execute()) {

    $_SESSION['nombre'] = $nombre;
    $_SESSION['gmail']  = $gmail;
    $_SESSION['id']     = $conexion->insert_id;
    $_SESSION['hora']   = date('d/m/Y H:i:s');
    unset($_SESSION['errores'], $_SESSION['form']); 
} else {

    $_SESSION['errores']['gmail'] = 'Este Gmail ya está registrado.';
    $_SESSION['form'] = ['nombre' => $nombre, 'gmail' => $gmail];
}

$stmt->close();
$conexion->close();

header('Location: index.php');
exit;
