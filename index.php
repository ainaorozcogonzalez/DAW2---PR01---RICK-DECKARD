<?php
session_start();
include('conexion.php');

$usuario = "";

$errorUsuario = $_SESSION['errorUsuario'] ?? '';
$errorContrasena = $_SESSION['errorContrasena'] ?? '';
unset($_SESSION['errorUsuario'], $_SESSION['errorContrasena']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/styles.css">
    <script src="./Js/validaciones.js"></script>
</head>

<body id="bodyLogIn">

    <div id="containerLogIn">
        <div class="left-section">
            <form action="validacion.php" method="POST">
                <div class="inputs">
                    <label class="labelLogIn" for="nombre">Usuario:</label>
                    <input class="inputLogIn" type="text" id="nombre" name="nombre" placeholder="Introducir usuario" value="<?php echo htmlspecialchars($usuario ?? ''); ?>">
                    <br><span id="error-nombre" class="error-message"><?php echo $errorUsuario; ?></span><br><br>
                </div>

                <div class="inputs">
                    <label class="labelLogIn" for="contraseña">Contraseña:</label>
                    <input class="inputLogIn" type="password" id="contraseña" name="contrasena" placeholder="Introducir contraseña">
                    <br><span id="error-contraseña" class="error-message"><?php echo $errorContrasena; ?></span><br><br>
                </div>

                <button type="submit" name="login" class="botonLogIn">Iniciar sesión</button>
            </form>
        </div>

        <div class="right-section">
            <img src="./img/LOGO-REST.png" alt="Logo" id="logoLogIn">
        </div>
    </div>

</body>

</html>
