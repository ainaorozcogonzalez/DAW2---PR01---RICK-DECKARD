<?php
    include_once("../conexion.php");
    session_start();

    if (!isset($_SESSION['loggedin']) && !isset($_SESSION['id_usuario'])) {
        header('Location: ' . '../index.php');
        exit();
    } else {
        $camareroActual = mysqli_real_escape_string($conn, htmlspecialchars($_SESSION['id_usuario']));

        
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header con Menú Desplegable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS (con Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Estilo para el contenedor de la imagen */
        .image-container {
            text-align: center;
            margin-top: 20px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Menú Terrazas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="terrazasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Terrazas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="terrazasDropdown">
                            <?php
                                
                                $sqlTerrazas = "SELECT * FROM salas WHERE id_sala <= 3";
                                $stmtTerrazas = mysqli_prepare($conn, $sqlTerrazas);
                                mysqli_stmt_execute($stmtTerrazas);
                                mysqli_stmt_store_result($stmtTerrazas);

                                if (mysqli_stmt_num_rows($stmtTerrazas) > 0) {

                                    mysqli_stmt_bind_result($stmtTerrazas, $id_sala, $nombre, $capacidad);

                                    while (mysqli_stmt_fetch($stmtTerrazas)) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="showImage(\'../img/' . htmlspecialchars($nombre) . '.jpg\')">' . htmlspecialchars($nombre) . '</a></li>';
                                    }

                                }
                                
                            ?>
                        </ul>
                    </li>
                    <!-- Menú Comedores -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="comedoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Comedores
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="comedoresDropdown">
                            <?php
                                
                                $sqlTerrazas = "SELECT * FROM salas WHERE id_sala BETWEEN 4 AND 5";
                                $stmtTerrazas = mysqli_prepare($conn, $sqlTerrazas);
                                mysqli_stmt_execute($stmtTerrazas);
                                mysqli_stmt_store_result($stmtTerrazas);

                                if (mysqli_stmt_num_rows($stmtTerrazas) > 0) {

                                    mysqli_stmt_bind_result($stmtTerrazas, $id_sala, $nombre, $capacidad);

                                    while (mysqli_stmt_fetch($stmtTerrazas)) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="showImage(\'../img/' . htmlspecialchars($nombre) . '.jpg\')">' . htmlspecialchars($nombre) . '</a></li>';
                                    }

                                }
                                
                            ?>
                        </ul>
                    </li>
                    <!-- Menú Salas Privadas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="salasPrivadasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Salas Privadas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="salasPrivadasDropdown">
                            <?php
                                
                                $sqlTerrazas = "SELECT * FROM salas WHERE id_sala BETWEEN 6 AND 8";
                                $stmtTerrazas = mysqli_prepare($conn, $sqlTerrazas);
                                mysqli_stmt_execute($stmtTerrazas);
                                mysqli_stmt_store_result($stmtTerrazas);

                                if (mysqli_stmt_num_rows($stmtTerrazas) > 0) {

                                    mysqli_stmt_bind_result($stmtTerrazas, $id_sala, $nombre, $capacidad);

                                    while (mysqli_stmt_fetch($stmtTerrazas)) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="showImage(\'../img/' . htmlspecialchars($nombre) . '.jpg\')">' . htmlspecialchars($nombre) . '</a></li>';
                                    }

                                }
                                
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        // SELECCIONAMOS todo DE 'mesas', JUNTAMOS con salas EN la id_sala,
        // JUNTAMOS (LEFT JOIN) 'ocupaciones' EN la id_mesa Y en el caso que la fecha de liberación SEA NULA, O sea mayor que la fecha actual (la mesa sigue ocupada, o sigue ocupada pero se liberará en una fecha futura a la de ahora)
        // JUNTAMOS (LEFT JOIN) 'usuarios' EN la id_usuario
        // CUANDO el camarero de la ocupacion sea el mismo que el usuario de la sesión, o el camarero SEA NULO (las mesas que están ocupadas y las que no)
        $sqlPáginaCamareros = "SELECT mesas.id_mesa, mesas.capacidad, mesas.estado, mesas.id_sala,
        salas.id_sala, salas.nombre, salas.capacidad,
        ocupaciones.id_ocupacion, ocupaciones.id_mesa, ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera,
        usuarios.id_usuario, usuarios.nombre_completo, usuarios.contraseña, usuarios.tipo_usuario
        FROM mesas
        INNER JOIN salas ON salas.id_sala = mesas.id_sala
        LEFT JOIN ocupaciones ON ocupaciones.id_mesa = mesas.id_mesa AND (ocupaciones.fecha_libera IS NULL OR ocupaciones.fecha_libera > NOW())
        LEFT JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario
        WHERE ocupaciones.id_usuario = ? OR ocupaciones.id_usuario IS NULL
        ORDER BY salas.id_sala, mesas.id_mesa";
        $stmtPáginaCamareros = mysqli_prepare($conn, $sqlPáginaCamareros);
        mysqli_stmt_bind_param($stmtPáginaCamareros, "i", $camareroActual);
        mysqli_stmt_execute($stmtPáginaCamareros);
        mysqli_stmt_store_result($stmtPáginaCamareros);

        if (mysqli_stmt_num_rows($stmtPáginaCamareros) > 0) {

            // Consulta a los datos de las 'mesas', 'salas', 'ocupaciones' y 'usuarios' (en orden)
            mysqli_stmt_bind_result($stmtPáginaCamareros, $id_mesa, $capacidadMesa, $estadoMesa, $idSalaDeLaMesa,
            $id_sala, $nombreSala, $capacidadSala,
            $idMesaOcupada, $idCamareroQueOfreceLaMesa, $fechaOcupacion, $fechaLibera,
            $id_usuario, $nombre, $contrasena, $tipoUsuario);


            while (mysqli_stmt_fetch($stmtPáginaCamareros)) {

                echo "<div>";
                
                echo "<p class=><strong>Mesa " . htmlspecialchars($id_mesa) . ":</strong> " . htmlspecialchars($estadoMesa) . "</p>";

                if ($nombre != NULL) {
                    echo "<p class=><strong>Camarero/a: </strong>" . htmlspecialchars($nombre) . "</p>";
                } else {
                    echo "<p class=><strong>Camarero/a: </strong> (Nadie ha asignado esta mesa) </p>";
                }

                echo "</div>";

            }
        } else {
            echo "<p>No hay mesas</p>";
        }

    ?>

    <!-- Contenedor para mostrar la imagen -->
    <div class="image-container">
        <img id="displayedImage" src="" alt="Selecciona una terraza" style="display: none;">
    </div>

    <script>
        
        // Función para mostrar la imagen según la terraza seleccionada
        function showImage(imageName) {
            const img = document.getElementById('displayedImage');
            img.src = imageName; // Asigna el nombre de la imagen al atributo src
            img.style.display = 'block'; // Muestra la imagen
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-7r82R3sMKeU9DAStBbXzTc98O/YMNZ4eF9NLMb13K3uqo/W9Y5Hk4HaeQOG99UZ3" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }
?>