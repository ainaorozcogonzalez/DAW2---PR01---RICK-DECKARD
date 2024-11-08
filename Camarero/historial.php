<?php

    include_once("../conexion.php");
    session_start();

    if (!isset($_SESSION['id_usuario'])) {

        header('Location: ' . '../index.php');
        exit();

    } else {

        $camareroActual = mysqli_real_escape_string($con, htmlspecialchars($_SESSION['id_usuario']));
        $buscar_sala = isset($_GET['buscar']) ? mysqli_real_escape_string($con, htmlspecialchars($_GET['buscar'])) : '';
        $fecha = isset($_GET['fecha']) ? mysqli_real_escape_string($con, htmlspecialchars($_GET['fecha'])) : '';

        // Verifica si se ha seleccionado algún filtro a través del parámetro `filtro`
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'default';

        // Configura la consulta SQL en función del filtro seleccionado
        switch ($filtro) {

            case 'ocupacion':

                $sqlHistorial = "SELECT ocupaciones.id_ocupacion, ocupaciones.id_mesa, ocupaciones.id_usuario, 
                    ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera, mesas.id_mesa, mesas.capacidad, 
                    mesas.estado, mesas.id_sala, usuarios.id_usuario, usuarios.nombre_completo, 
                    usuarios.contraseña, usuarios.tipo_usuario
                    FROM ocupaciones
                    INNER JOIN mesas ON mesas.id_mesa = ocupaciones.id_mesa
                    INNER JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario";
                break;

            case 'sala':

                $sqlHistorial = "SELECT salas.id_sala, salas.nombre, salas.capacidad, 
                    mesas.id_mesa, mesas.capacidad AS capacidad_mesa, mesas.estado, mesas.id_sala
                    FROM salas
                    INNER JOIN mesas ON salas.id_sala = mesas.id_sala";
                break;

            case 'uso':

                $sqlHistorial = "SELECT ocupaciones.id_ocupacion, ocupaciones.id_mesa, COUNT(ocupaciones.id_mesa) AS numero_de_usos, 
                    GROUP_CONCAT(ocupaciones.id_ocupacion) AS ocupaciones_concatenadas, mesas.capacidad, mesas.estado, mesas.id_sala,
                    salas.id_sala, salas.nombre, salas.capacidad
                    FROM ocupaciones
                    INNER JOIN mesas ON mesas.id_mesa = ocupaciones.id_mesa
                    INNER JOIN salas ON salas.id_sala = mesas.id_sala
                    GROUP BY ocupaciones.id_mesa
                    ORDER BY numero_de_usos DESC";
                break;

            default:

                $sqlHistorial = "SELECT mesas.id_mesa AS id_mesa, mesas.capacidad, mesas.estado, mesas.id_sala,
                    salas.id_sala, salas.nombre, salas.capacidad,
                    ocupaciones.id_ocupacion, ocupaciones.id_mesa AS id_mesas_ocupadas, ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera,
                    usuarios.id_usuario, usuarios.nombre_completo, usuarios.contraseña, usuarios.tipo_usuario
                    FROM mesas
                    INNER JOIN salas ON salas.id_sala = mesas.id_sala
                    LEFT JOIN ocupaciones ON ocupaciones.id_mesa = mesas.id_mesa
                    LEFT JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario 
                    ORDER BY salas.id_sala, mesas.id_mesa";
                break;

                if ($buscar_sala != "") {

                    $sqlHistorial = "SELECT mesas.id_mesa AS id_mesa, mesas.capacidad, mesas.estado, mesas.id_sala,
                    salas.id_sala, salas.nombre, salas.capacidad,
                    ocupaciones.id_ocupacion, ocupaciones.id_mesa AS id_mesas_ocupadas, ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera,
                    usuarios.id_usuario, usuarios.nombre_completo, usuarios.contraseña, usuarios.tipo_usuario
                    FROM mesas
                    INNER JOIN salas ON salas.id_sala = mesas.id_sala
                    LEFT JOIN ocupaciones ON ocupaciones.id_mesa = mesas.id_mesa
                    LEFT JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario
                    WHERE salas.nombre LIKE ?
                    ORDER BY salas.id_sala, mesas.id_mesa;";

                }

                if ($fecha != "") {

                    $sqlHistorial .= "SELECT mesas.id_mesa AS id_mesa, mesas.capacidad, mesas.estado, mesas.id_sala,
                    salas.id_sala, salas.nombre, salas.capacidad,
                    ocupaciones.id_ocupacion, ocupaciones.id_mesa AS id_mesas_ocupadas, ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera,
                    usuarios.id_usuario, usuarios.nombre_completo, usuarios.contraseña, usuarios.tipo_usuario
                    FROM mesas
                    INNER JOIN salas ON salas.id_sala = mesas.id_sala
                    LEFT JOIN ocupaciones ON ocupaciones.id_mesa = mesas.id_mesa
                    LEFT JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario
                    WHERE ocupaciones.fecha_ocupacion LIKE ?
                    ORDER BY salas.id_sala, mesas.id_mesa;";
                    
                }
        }

        $buscarSala = '%' . $buscar_sala . '%';
        $buscarFecha = '%' . $fecha . '%';

        if ($buscar_sala != "") {
            // Ejecuta la consulta y guarda los resultados
            $stmtPáginaHistorial = mysqli_prepare($con, $sqlHistorial);
            mysqli_stmt_bind_param($stmtPáginaHistorial, "s", $buscarSala);
            mysqli_stmt_execute($stmtPáginaHistorial);
            $resultado = mysqli_stmt_get_result($stmtPáginaHistorial);
        }

        if ($fecha != "") {
            // Ejecuta la consulta y guarda los resultados
            $stmtPáginaHistorial = mysqli_prepare($con, $sqlHistorial);
            mysqli_stmt_bind_param($stmtPáginaHistorial, "s", $buscarFecha);
            mysqli_stmt_execute($stmtPáginaHistorial);
            $resultado = mysqli_stmt_get_result($stmtPáginaHistorial);
        }

        // Ejecuta la consulta y guarda los resultados
        $stmtPáginaHistorial = mysqli_prepare($con, $sqlHistorial);
        mysqli_stmt_execute($stmtPáginaHistorial);
        $resultado = mysqli_stmt_get_result($stmtPáginaHistorial);

    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mesas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
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
                    <form class="form-inline my-2 my-lg-0" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="buscar" placeholder="Buscar" aria-label="Buscar">
                    </form>
                    <form style="margin-left: 10px; margin-right: 10px;" method="GET"> 
                        <input style="color: #000000A6;" class="form-control mr-sm-2" type="date" id="start" name="fecha" value="0000-00-00"/>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=default">Historial Mesas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=ocupacion">Ocupaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=sala">Salas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=uso">Mesas más usadas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <?php if ($filtro == 'ocupacion') : ?>
            <h2>Ocupaciones</h2>
        <?php elseif ($filtro == 'uso') : ?>
            <h2>Mesas más usadas a menos</h2>
        <?php elseif ($filtro == 'sala') : ?>
            <h2>Salas</h2>
        <?php else : ?>
            <h2>Historial mesas</h2>
        <?php endif; ?>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php if ($filtro == 'ocupacion') : ?>

                        <th>Ocupación</th>
                        <th>Mesa</th>
                        <th>Estado</th>
                        <th>Camarero</th>
                        <th>Fecha ocupación</th>
                        <th>Fecha liberación</th>

                    <?php elseif ($filtro == 'uso') : ?>

                        <th>Número de Usos</th>
                        <th>Mesa</th>
                        <th>Salas</th>
                        <th>Ocupaciones</th>

                    <?php elseif ($filtro == 'sala') : ?>

                        <th>Nombre Sala</th>
                        <th>Capacidad Sala</th>

                    <?php else : ?>

                        <th>Ocupación</th>
                        <th>Mesa</th>
                        <th>Sala</th>
                        <th>Estado</th>
                        <th>Camarero</th>
                        <th>Fecha ocupación</th>
                        <th>Fecha liberación</th>

                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php

                    // Si existe $resultado y devuelve filas
                    if ($resultado && mysqli_num_rows($resultado) > 0) {

                        while ($fila = mysqli_fetch_assoc($resultado)) {


                            echo "<tr>";


                            // MOSTRAR OCUPACIONES
                            if ($filtro == 'ocupacion') {

                                if ($fila['id_ocupacion'] != NULL) {

                                    echo "<td>Ocupación ".$fila['id_ocupacion']."</td>";

                                } else {

                                    echo "<td>Esta mesa aún no ha sido ocupada</td>";

                                }
                                
                                echo "<td>Mesa ".$fila['id_mesa']."</td>";
                                echo "<td>".$fila['estado']."</td>";

                                if ($fila['id_usuario'] != NULL) {

                                    echo "<td>".$fila['nombre_completo']."</td>";

                                } else {

                                    echo "<td> Ningún camarero ha asignado esta mesa </td>";

                                }

                                echo "<td>".$fila['fecha_ocupacion']."</td>";

                                if ($fila['fecha_libera'] != NULL) {

                                    echo "<td>".$fila['fecha_libera']."</td>";

                                } else {

                                    echo "<td> Esta mesa actualmente está siendo ocupada </td>";

                                }
                                

                            // MOSTRAR DE LAS MESAS MÁS USADAS A MENOS
                            } elseif ($filtro == 'uso') {

                                if ($fila['numero_de_usos'] == 1) {

                                    echo "<td>".$fila['numero_de_usos']." vez</td>";

                                } else {

                                    echo "<td>".$fila['numero_de_usos']." veces</td>";

                                }
                                
                                echo "<td>Mesa ".$fila['id_mesa']."</td>";

                                
                                echo "<td>".$fila['nombre']."</td>";

                                echo "<td>";

                                    // Busca todas las comas en el string de las ocupaciones concatenadas y lo reemplaza por ', Ocupación '
                                    echo "Ocupación " . str_replace(',', ', Ocupación ', $fila['ocupaciones_concatenadas']);

                                echo "</td>";


                            // MOSTRAR SALAS
                            } elseif ($filtro == 'sala') {

                                echo "<td>".$fila['nombre']."</td>";
                                echo "<td>".$fila['capacidad']."</td>";


                            // MOSTRAR TANTO LAS MESAS OCUPADAS Y NO OCUPADAS
                            } else {

                                if ($fila['id_ocupacion'] != NULL) {

                                    echo "<td style='width: 22%;' >Ocupación ".$fila['id_ocupacion']."</td>";

                                } else {

                                    echo "<td style='width: 22%;'>Esta mesa aún no ha sido ocupada</td>";

                                }
                                
                                // Si la ID de esta mesa está ocupada, mostraremos la ID de la mesa desde la tabla 'ocupaciones',
                                // Si no lo está, mostraremos la ID de la mesa de la tabla 'mesas'
                                if ($fila['id_mesas_ocupadas'] != NULL) {

                                    echo "<td style='width: 6%;'>Mesa ".$fila['id_mesas_ocupadas']."</td>";
                                    
                                } else {

                                    echo "<td style='width: 6%;'>Mesa ".$fila['id_mesa']."</td>";
                                    
                                }

                                echo "<td>".$fila['nombre']."</td>";

                                echo "<td>".$fila['estado']."</td>";

                                if ($fila['id_usuario'] != NULL) {

                                    echo "<td style='width: 25%;'>".$fila['nombre_completo']."</td>";

                                } else {

                                    echo "<td style='width: 25%;'> Ningún camarero ha asignado esta mesa </td>";

                                }


                                if ($fila['fecha_ocupacion'] != NULL) {
                                    
                                    echo "<td style='width: 20%;'>".$fila['fecha_ocupacion']."</td>";

                                } else {

                                    echo "<td style='width: 20%;'> Esta mesa aún no se ha ocupado </td>";
                                    
                                }
                                
                                // Si existe la fecha de liberación de la ocupación, se muestra
                                // Si NO existe, Y no está ocupada (en la tabla "ocupaciones"), está ocupada
                                // Si NO existe, Y está ocupada (en la tabla "ocupaciones"), aún no se ha ocupado
                                if ($fila['fecha_libera'] != NULL) {

                                    echo "<td style='width: 20%;'>".$fila['fecha_libera']."</td>";

                                } elseif ($fila['fecha_libera'] == NULL && $fila['id_ocupacion'] != NULL) {

                                    echo "<td style='width: 20%;'> Esta mesa actualmente está siendo ocupada</td>";
                                    
                                } elseif ($fila['id_ocupacion'] == NULL) {
                                    
                                    echo "<td style='width: 20%;'> Esta mesa aún no se ha ocupado </td>";

                                }

                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No hay resultados</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
