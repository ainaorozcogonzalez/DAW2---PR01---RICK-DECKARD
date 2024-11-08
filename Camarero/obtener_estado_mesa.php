<?php
// obtener_estado_mesa.php

include('../conexion.php');

// Verificar si se ha enviado el ID de la mesa
if (isset($_GET['id_mesa'])) {
    $id_mesa = $_GET['id_mesa'];

    // Consulta para obtener el estado de la mesa
    $sql = "SELECT estado FROM mesas WHERE id_mesa = $id_mesa";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Obtener el estado
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['estado' => $row['estado']]);
    } else {
        echo json_encode(['estado' => 'libre']);
    }
} else {
    echo json_encode(['estado' => 'libre']);
}

// Cerrar la conexión
mysqli_close($con);
?>
