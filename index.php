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
    }
    ?>

    <div class="container">
        <div class="left-section">
            <form action="" method="POST">
                <div class="inputs">
                    <label for="nombre">Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introducir usuario" value="<?php echo htmlspecialchars($usuario); ?>">
                    <br><span id="error-nombre" class="error-message"><?php echo $errorUsuario; ?></span><br><br>

                </div>
                <div class="inputs">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" class="form-control" id="contraseña" name="contrasena" placeholder="Introducir contraseña" value="<?php echo htmlspecialchars($usuario); ?>">
                    <br><span id="error-contraseña" class="error-message"><?php echo $errorContrasena; ?></span><br><br>
<<<<<<< HEAD
                    <br><span id="error-nombre" class="error-message"><?php echo $errorUsuario; ?></span><br><br>
=======
>>>>>>> 526382e846e19097445e6da9e198dde8217e6d86
                </div>
                <button type="submit" name="login" class="boton">Iniciar sesión</button>
            </form>
        </div>

        <div class="right-section">
            <img src="./img/LOGO-REST.png" alt="Logo" class="logo">
        </div>
    </div>

</body>

</html>