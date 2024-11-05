<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="validaciones.js"></script>
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

// Variables para almacenar valores de entrada y errores
$usuario = $contrasena = "";
$errorUsuario = $errorContrasena = "";

// Procesar el formulario si fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar las entradas
    $usuario = htmlspecialchars(mysqli_real_escape_string($conexion, $_POST['usuario']));
    $contrasena = htmlspecialchars(mysqli_real_escape_string($conexion, $_POST['contrasena']));

    // Validación de campos vacíos
    if (empty($usuario)) {
        $errorUsuario = "Debes ingresar un nombre de usuario";
    }
    if (empty($contrasena)) {
        $errorContrasena = "Debes ingresar una contraseña";
    }

    // Si no hay errores, procedemos a validar contra la base de datos
    if (empty($errorUsuario) && empty($errorContrasena)) {
        // Ejecutar la consulta para obtener el usuario, contraseña encriptada y rol
        $consulta = "SELECT id_usuario, contraseña, rol FROM usuarios WHERE usuario = '$usuario'";
        $resultado = mysqli_query($conexion, $consulta);

        // Comprobamos si el usuario existe
        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);

            // Verificar la contraseña encriptada
            if (password_verify($contrasena, $fila['contraseña'])) {
                // Contraseña correcta, iniciar sesión y redirigir según el rol
                $_SESSION['id_usuario'] = $fila['id_usuario'];

                // Verificar el rol del usuario
                if ($fila['rol'] === 'camarero') {
                    header("Location: camarero.php");
                } elseif ($fila['rol'] === 'manager') {
                    header("Location: manager.php");
                } else {
                    // Si el rol no es ni 'camarero' ni 'manager', redirigir a una página de error o predeterminada
                    header("Location: inicio.php");
                }
                exit();
            } else {
                // Contraseña incorrecta
                $errorContrasena = "La contraseña es incorrecta.";
            }
        } else {
            // Usuario no encontrado
            $errorUsuario = "El usuario no existe.";
        }
    }
}
?>

<h1>Iniciar Sesión</h1>
<form method="POST" action="index.php">
    <input type="text" name="usuario" id="nombre" placeholder="Nombre y apellido" value="<?php echo $usuario; ?>">
    <br>
    <span id="error-nombre" style="color: red;"><?php echo $errorUsuario; ?></span>
    <br>
    <input type="password" name="contrasena" id="contraseña" placeholder="Contraseña">
    <br>
    <span id="error-contraseña" style="color: red;"><?php echo $errorContrasena; ?></span>
    <br><br>
    <input type="submit" name="iniciar_sesion" value="Iniciar Sesión">
</form>

</body>
</html>
