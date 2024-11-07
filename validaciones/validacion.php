<?php
session_start();
include('conexion.php');

$usuario = $contrasena = "";
$errorUsuario = $errorContrasena = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nombre']));
    $contrasena = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['contrasena'])));

    // Validación de campos vacíos
    if (empty($usuario)) {
        $errorUsuario = "Debes ingresar un nombre de usuario";
    }
    if (empty($contrasena)) {
        $errorContrasena = "Debes ingresar una contraseña";
    }

    // Si no hay errores, validamos en la base de datos
    if (empty($errorUsuario) && empty($errorContrasena)) {
        $consulta = "SELECT id_usuario, contraseña, tipo_usuario FROM Usuarios WHERE nombre_completo = '$usuario'";
        $resultado = mysqli_query($con, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);

            if (password_verify($contrasena, $fila['contraseña'])) {
                $_SESSION['id_usuario'] = $fila['id_usuario'];

                // Redirigir según el tipo de usuario
                if ($fila['tipo_usuario'] === 'camarero') {
                    header("Location: ./Camarero/camarero_home.php");
                } elseif ($fila['tipo_usuario'] === 'manager') {
                    header("Location: ./Manager/manager.php");
                }
                exit();
            } else {
                $errorContrasena = "El usuario o contraseña no son correctos";
            }
        } else {
            $errorUsuario = "El usuario o contraseña no son correctos";
        }
    }

    // Almacenar los mensajes de error en la sesión
    $_SESSION['errorUsuario'] = $errorUsuario;
    $_SESSION['errorContrasena'] = $errorContrasena;

    // Redirigir de nuevo a index.php si hay errores
    header("Location: index.php");
    exit();
}
?>
