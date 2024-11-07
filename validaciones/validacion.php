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


    if ($errorUsuario && $errorContrasena) {

        $datosRecibidos = array(
            'usuario' => $usuario,
            'contrasena' => $contrasena
        );
    
        $datosDevueltos=http_build_query($datosRecibidos);
        header("Location: ../index.php". $errorUsuario. "&". $errorContrasena. "&" . $datosDevueltos);
        exit();
    }else{
        echo"<form id='EnvioCheck' action='./Camarero/camarero_home.php' method='POST'>";
        echo"<input type='hidden' id='nombre' name='nombre' value='".$usuario."'>";
        echo"<input type='hidden' id='contrasena' name='contrasena' value='".$contrasena."'>";
        echo"</form>";
        echo "<script>document.getElementById('EnvioCheck').submit();</script>";
    }
    
    ?>