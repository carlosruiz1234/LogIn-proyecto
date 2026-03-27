<?php


$host     = 'localhost';      
$usuario  = 'root';           
$password = '';              
$base     = 'login_project'; 


$conexion = new mysqli($host, $usuario, $password, $base);


if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}


$conexion->set_charset('utf8mb4');
