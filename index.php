<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

<?php

session_start();
include('conexion.php');


if (isset($_SESSION['id_usuario'])) {
    header("Location: inicio.php");
    exit();
}

?>


<h1>Iniciar Sesión</h1>
            <form method="POST" action="index.php">
                <input type="text" name="usuario" placeholder="Nombre y apellido" required>
                <br>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <br>
                <input type="submit" name="iniciar_sesion" value="Iniciar Sesión">
            </form>


    
</body>
</html>