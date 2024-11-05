<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../src/LOGO/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="flex" id="oscuro">
        <div class="container">
            <h2 class="flex" id="titulo">INICIO DE SESION</h2>
            <br>

            <form action="./validacion.php" method="POST">
                <div class="inputs">
                    <label for="nombre">Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php if(isset($_GET['nombre'])) {echo $_GET['nombre'];} ?>">
                    <?php if (isset($_GET['usernameVacio'])) {echo "<br><br><p style='color: red;'>Falta tu nombre</p>"; } ?>
                </div>
                <div class="inputs">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena">
                    <?php if (isset($_GET['contrasenaVacio'])) {echo "<br><br><p style='color: red;'>Escribe tu contraseña</p>"; } ?>
                    <?php if (isset($_GET['contrasenaMal']) || isset($_GET['usernameMal'])) {echo "<br><br><p style='color: red;'>Usuario o contraseña incorrecta</p>"; } ?>
                </div>
                <br>
                <br>
                <button type="submit" name="login" value="login" class="boton">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>

</html>