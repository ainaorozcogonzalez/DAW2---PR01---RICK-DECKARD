<?php
    include_once("../conexion.php");
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header('Location: ' . '../index.php');
        exit();
    } else {
        $camareroActual = mysqli_real_escape_string($con, htmlspecialchars($_SESSION['id_usuario']));

        // Verifica si se ha seleccionado algún filtro a través del parámetro `filtro`
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'default';

        // Configura la consulta SQL en función del filtro seleccionado
        switch ($filtro) {
            case 'ocupacion':
                $sqlPáginaCamareros = "SELECT ocupaciones.id_ocupacion, ocupaciones.id_mesa, ocupaciones.id_usuario, 
                    ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera, mesas.id_mesa, mesas.capacidad, 
                    mesas.estado, mesas.id_sala, usuarios.id_usuario, usuarios.nombre_completo, 
                    usuarios.contraseña, usuarios.tipo_usuario
                    FROM ocupaciones
                    INNER JOIN mesas ON mesas.id_mesa = ocupaciones.id_mesa
                    INNER JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario";
                break;

            case 'sala':
                $sqlPáginaCamareros = "SELECT salas.id_sala, salas.nombre, salas.capacidad, 
                    mesas.id_mesa, mesas.capacidad AS capacidad_mesa, mesas.estado, mesas.id_sala
                    FROM salas
                    INNER JOIN mesas ON salas.id_sala = mesas.id_sala";
                break;

            case 'uso':
                $sqlPáginaCamareros = "SELECT ocupaciones.id_ocupacion, ocupaciones.id_mesa, COUNT(ocupaciones.id_mesa) AS numero_de_usos, 
                    mesas.capacidad, mesas.estado, mesas.id_sala
                    FROM ocupaciones
                    INNER JOIN mesas ON mesas.id_mesa = ocupaciones.id_mesa
                    GROUP BY ocupaciones.id_mesa
                    ORDER BY numero_de_usos DESC";
                break;

            default:
                $sqlPáginaCamareros = "SELECT mesas.id_mesa, mesas.capacidad, mesas.estado, mesas.id_sala,
                    salas.id_sala, salas.nombre, salas.capacidad,
                    ocupaciones.id_ocupacion, ocupaciones.id_mesa, ocupaciones.fecha_ocupacion, ocupaciones.fecha_libera,
                    usuarios.id_usuario, usuarios.nombre_completo, usuarios.contraseña, usuarios.tipo_usuario
                    FROM mesas
                    INNER JOIN salas ON salas.id_sala = mesas.id_sala
                    LEFT JOIN ocupaciones ON ocupaciones.id_mesa = mesas.id_mesa
                    LEFT JOIN usuarios ON usuarios.id_usuario = ocupaciones.id_usuario
                    WHERE ocupaciones.id_usuario IS NOT NULL OR ocupaciones.id_usuario IS NULL
                    ORDER BY salas.id_sala, mesas.id_mesa";
                break;
        }

        // Ejecuta la consulta y guarda los resultados
        $stmtPáginaCamareros = mysqli_prepare($con, $sqlPáginaCamareros);
        mysqli_stmt_execute($stmtPáginaCamareros);
        $resultado = mysqli_stmt_get_result($stmtPáginaCamareros);

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
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=ocupacion">Filtrar por ocupación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=sala">Filtrar por sala</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=uso">Filtrar por uso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?filtro=default">Mostrar todo</a>
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

                        <th>Ocupación</th>
                        <th>Mesa</th>
                        <th>Número de Usos</th>

                    <?php elseif ($filtro == 'sala') : ?>

                        <th>Nombre Sala</th>
                        <th>Capacidad Sala</th>

                    <?php else : ?>

                        <th>Ocupación</th>
                        <th>Mesa</th>
                        <th>Estado</th>
                        <th>Camarero</th>

                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php

                    // Si existe $resultado y devuelve filas
                    if ($resultado && mysqli_num_rows($resultado) > 0) {

                        while ($fila = mysqli_fetch_assoc($resultado)) {

                            echo "<tr>";

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
                                
                            } elseif ($filtro == 'uso') {

                                echo "<td>Ocupación ".$fila['id_ocupacion']."</td>";
                                echo "<td>Mesa ".$fila['id_mesa']."</td>";

                                if ($fila['numero_de_usos'] == 1) {

                                    echo "<td>".$fila['numero_de_usos']." vez</td>";

                                } else {

                                    echo "<td>".$fila['numero_de_usos']." veces</td>";

                                }

                            } elseif ($filtro == 'sala') {

                                echo "<td>".$fila['nombre']."</td>";
                                echo "<td>".$fila['capacidad']."</td>";

                            } else {

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
