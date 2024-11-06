

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="validaciones.js"></script>

</head>


<body>


<?php
session_start();
include('conexion.php');

if (isset($_SESSION['id_usuario'])) {
    header("Location: inicio.php");
    exit();
}

// Inicializar variables
$usuario = $contrasena = "";
$errorUsuario = $errorContrasena = "";

// Procesar el formulario si fue enviado
// Procesar el formulario si fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar las entradas
    $usuario = htmlspecialchars(mysqli_real_escape_string($con, $_POST['usuario']));
    $contrasena = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['contraseña']))); // Uso de trim

    // Validación de campos vacíos
    if (empty($usuario)) {
        $errorUsuario = "Debes ingresar un nombre de usuario";
    }
    if (empty($contrasena)) {
        $errorContrasena = "Debes ingresar una contraseña";
    }

}
    ?>

    <div class="flex" id="oscuro">
        <div class="container">
            <h2 class="flex" id="titulo">INICIO DE SESION</h2>
            <br>

            <form action="" method="POST">
                <div class="inputs">
                    <label for="nombre">Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php if(isset($_GET['nombre'])) {echo $_GET['nombre'];} ?>">
                    <span id="error-nombre" style="color: red;"></span>
                    <?php if (isset($_GET['usernameVacio'])) {echo "<br><br><p style='color: red;'>Falta tu nombre</p>"; } ?>
                </div>
                <div class="inputs">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="contraseña" name="contrasena">
                    <span id="error-contraseña" style="color: red;"></span>
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