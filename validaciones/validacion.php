<?php
session_start();
include('../conexion.php');

// Verificar si se ha enviado el formulario de login
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['login'])) {
    // Redirigir al login si no es una solicitud POST o el formulario no está enviado
    header("Location: ../index.php");
    exit();
}

$usuario = mysqli_real_escape_string($con, $_POST['nombre']);
$contrasena = mysqli_real_escape_string($con, $_POST['contrasena']);

// Consulta para verificar si el usuario existe
$consulta = "SELECT id_usuario, contraseña, tipo_usuario FROM usuarios WHERE nombre_completo = '$usuario'";
$resultado = mysqli_query($con, $consulta);

// Verificar si el usuario existe en la base de datos
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);

    // Verificar la contraseña
    if (password_verify($contrasena, $fila['contraseña'])) {
        // Almacenar el id_usuario en la sesión
        $_SESSION['id_usuario'] = $fila['id_usuario'];

        // Redirigir según el tipo de usuario
        if ($fila['tipo_usuario'] === 'camarero') {
            header("Location: ../Camarero/camarero_home.php");
        } elseif ($fila['tipo_usuario'] === 'manager') {
            header("Location: ../Manager/manager_home.php");
        }
        exit();
    } else {
        // Si la contraseña no es correcta, redirigir con error
        $_SESSION['nombre'] = $usuario;  // Guardamos el nombre en la sesión
        header("Location: ../index.php?error=incorrecto");
        exit();
    }
} else {
    // Si el usuario no existe, redirigir con error
    $_SESSION['nombre'] = $usuario;  // Guardamos el nombre en la sesión
    header("Location: ../index.php?error=incorrecto");
    exit();
}
?>
