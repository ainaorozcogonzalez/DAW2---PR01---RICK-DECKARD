<?php

$host = "localhost";
$usuario = "root";
$contrasena = "Agustin51";
$nombre_bd = "db_restaurante";
$con = mysqli_connect($host, $usuario, $contrasena, $nombre_bd);

if (mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
?>
