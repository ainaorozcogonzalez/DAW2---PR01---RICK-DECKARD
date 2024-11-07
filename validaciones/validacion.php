<?php
    session_start();
    include('../conexion.php');

    $error="";
    function validaCampoVacio($campo) {
        if(empty($campo)){
            $error= true; //Hay un error
        }else{
            $error= false; //No hay un error
        }
        return $error;
    }

    if (!filter_has_var(INPUT_POST, 'login')) {
        header('Location: '.'../index.php');
        exit();

    } else {

        $errores="";
        
        $usuario = $contrasena = "";
        $errorUsuario = $errorContrasena = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nombre']));
            $contrasena = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['contrasena'])));


            // if (validaCampoVacio($usuario)){
            //     if (!$errores){
            //         $errores .="?usernameVacio=true";
            //     } else {
            //         $errores .="&usernameVacio=true";        
            //     }
            // }
            
            // if (validaCampoVacio($contrasena)){
            //     if (!$errores){
            //         $errores .="?contrasenaVacio=true";
            //      } else {
            //         $errores .="&contrasenaVacio=true";        
            //      }
            // }

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
                        if ($contrasena != "") {
                            if (!$errores){
                                $errores .="?contrasenaMal=true";
                            } else {
                                $errores .="&contrasenaMal=true";        
                            }
                        }
                    }
                } else {
                    if ($usuario != "") {
                            if (!$errores){
                                $errores .="?usernameMal=true";
                            } else {
                                $errores .="&usernameMal=true";        
                            }
                    }
                }
            }

        }


        if ($errores!=""){

            $datosRecibidos = array(
                'nombre' => $usuario,
                'contrasena' => $contrasena
            );
        
            $datosDevueltos=http_build_query($datosRecibidos);
            header("Location: ../index.php". $errores. "&". $datosDevueltos);
            exit();
        
           
        }
    }
    
    
    ?>