<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombre     = trim($_POST['nombre']     ?? '');
$gmail      = trim($_POST['gmail']      ?? '');
$contrasena = $_POST['contrasena']      ?? '';
$confirmar  = $_POST['confirmar']       ?? '';

$errores = [];

// validacion para nobre
if ($nombre === '') {
    $errores['err_nombre'] = 'El nombre no puede estar vacío.';
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
//_____________________________________________
if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($gmail, '@gmail.com')) {
    $errores['err_gmail'] = 'Ingresa un correo Gmail válido (@gmail.com).';
}
if (str_contains($gmail, ' ')) {
    $errores['err_gmail'] = 'El correo no puede tener espacios.';
}
//______________________________________________
if (strlen($contrasena) < 6) {
    $errores['err_contrasena'] = 'La contraseña debe tener al menos 6 caracteres.';
}
if (!preg_match('/[\W_]/', $contrasena)) {
    $errores['err_contrasena'] = 'Debe tener al menos un símbolo (!, @, #...).';
}
if (strlen($contrasena) > 30) {
    $errores['err_contrasena'] = 'La contraseña no puede superar los 30 caracteres.';
}
//______________________________________________
if ($contrasena !== $confirmar) {
    $errores['err_confirmar'] = 'Las contraseñas no coinciden.';
}


if (!empty($errores)) {
    $params = http_build_query(array_merge($errores, [
        'nombre' => $nombre,
        'gmail'  => $gmail,
    ]));
    header('Location: index.php?' . $params);
    exit;
}

$params = http_build_query([
    'ok'     => '1',
    'nombre' => $nombre,
    'gmail'  => $gmail,
]);
header('Location: index.php?' . $params);
exit;
