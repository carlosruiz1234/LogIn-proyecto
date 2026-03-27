<?php

session_start();
session_destroy(); // borra todos los datos de $_SESSION

header('Location: index.php');
exit;
