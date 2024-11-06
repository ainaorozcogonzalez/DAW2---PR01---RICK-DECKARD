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




$usuario = $contrasena = "";
$errorUsuario = $errorContrasena = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nombre']));
    $contrasena = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['contrasena'])));

    // Validación de campos vacíos php
    if (empty($usuario)) {
        $errorUsuario = "Debes ingresar un nombre de usuario";
    }
    if (empty($contrasena)) {
        $errorContrasena = "Debes ingresar una contraseña";
    }

    // Si no hay errores, procedemos a validar contra la base de datos
    if (empty($errorUsuario) && empty($errorContrasena)) {
        $consulta = "SELECT id_usuario, contraseña, tipo_usuario FROM Usuarios WHERE nombre_completo = '$usuario'";
        $resultado = mysqli_query($con, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);

            if (password_verify($contrasena, $fila['contraseña'])) {
                $_SESSION['id_usuario'] = $fila['id_usuario'];

                // Redirigir según el tipo de usuario
                if ($fila['tipo_usuario'] === 'camarero') {
                    header("Location: camarero.php");
                } elseif ($fila['tipo_usuario'] === 'manager') {
                    header("Location: manager.php");
                }
                exit();
            } else {
                $errorContrasena = "La contraseña es incorrecta.";
            }
        } else {
            $errorUsuario = "El usuario no existe.";
        }
    }
}
?>

<div class="flex" id="oscuro">
    <div class="container">
        <h2 class="flex" id="titulo">INICIO DE SESIÓN</h2>
        <form action="" method="POST">
            <div class="inputs">
                <label for="nombre">Usuario:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario); ?>">
                <span id="error-nombre" style="color: red;"><?php echo $errorUsuario; ?></span>
            </div>
            <div class="inputs">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contrasena" value="<?php echo htmlspecialchars($usuario); ?>" >
                <span id="error-contraseña" style="color: red;"><?php echo $errorContrasena; ?></span>
            </div>
            <br><br>
            <button type="submit" name="login" class="boton">Iniciar sesión</button>
        </form>
    </div>
</div>

</body>
</html>
