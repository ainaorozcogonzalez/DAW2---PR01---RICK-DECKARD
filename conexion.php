<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombre_bd = "";

$con = mysqli_connect($host, $usuario, $contrasena, $nombre_bd);

if (mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

try {

    $conn = mysqli_connect($host, $usuario,$contrasena, $nombre_bd);
    echo "conectado con el servidor <br>";
}
catch (Exception $e) {
    echo "Error de conexión: ". $e->getMessage();
    die();
}



?>
