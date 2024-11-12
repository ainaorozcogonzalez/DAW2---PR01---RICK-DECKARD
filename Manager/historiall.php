<?php
// Conexión a la base de datos
include_once("../conexion.php");
session_start();

// Definir variables para los filtros
$fechaInicio = $_POST['fecha_inicio'] ?? '';
$fechaFin = $_POST['fecha_fin'] ?? '';
$idUsuario = $_POST['id_usuario'] ?? '';
$estado = $_POST['estado'] ?? '';
$idSala = $_POST['id_sala'] ?? '';
$idMesa = $_POST['id_mesa'] ?? '';
$capacidadMesa = $_POST['capacidad_mesa'] ?? '';
$sillasOcupadas = $_POST['sillas_ocupadas'] ?? '';

// Construir consulta SQL
$sql = "SELECT o.id_ocupacion, u.nombre_completo AS camarero, s.nombre AS sala, m.id_mesa, m.capacidad AS capacidad_mesa,
        o.sillas AS sillas_ocupadas, o.fecha_ocupacion, o.fecha_libera,
        CASE WHEN o.fecha_libera IS NULL THEN 'Ocupada' ELSE 'Libre' END AS estado
        FROM ocupaciones o
        JOIN usuarios u ON o.id_usuario = u.id_usuario
        JOIN mesas m ON o.id_mesa = m.id_mesa
        JOIN salas s ON m.id_sala = s.id_sala
        WHERE 1=1";

// Aplicar filtros dinámicos
if (!empty($fechaInicio) && !empty($fechaFin)) {
    $sql .= " AND o.fecha_ocupacion BETWEEN '$fechaInicio' AND '$fechaFin'";
}
if (!empty($idUsuario)) {
    $sql .= " AND o.id_usuario = '$idUsuario'";
}
if (!empty($estado)) {
    $sql .= $estado === 'Ocupada' ? " AND o.fecha_libera IS NULL" : " AND o.fecha_libera IS NOT NULL";
}
if (!empty($idSala)) {
    $sql .= " AND s.id_sala = '$idSala'";
}
if (!empty($idMesa)) {
    $sql .= " AND m.id_mesa = '$idMesa'";
}
if (!empty($capacidadMesa)) {
    $sql .= " AND m.capacidad = '$capacidadMesa'";
}
if (!empty($sillasOcupadas)) {
    $sql .= " AND o.sillas = '$sillasOcupadas'";
}

$sql .= " ORDER BY o.fecha_ocupacion DESC";
$resultado = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ocupaciones</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>

<a href="./manager_home.php" class="back-button">Volver</a>

<h2>Historial de Ocupaciones</h2>




<form method="post" class="filter-form">
    <label for="fecha_inicio">Fecha Inicio:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($fechaInicio) ?>">

    <label for="fecha_fin">Fecha Fin:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($fechaFin) ?>">

    <label for="id_usuario">Usuario:</label>
    <select id="id_usuario" name="id_usuario">
        <option value="">Todos</option>
        <?php
        $usuarios = $con->query("SELECT id_usuario, nombre_completo FROM usuarios");
        while ($usuario = $usuarios->fetch_assoc()) {
            $selected = $usuario['id_usuario'] == $idUsuario ? 'selected' : '';
            echo "<option value='{$usuario['id_usuario']}' $selected>{$usuario['nombre_completo']}</option>";
        }
        ?>
    </select>

    <label for="estado">Estado:</label>
    <select id="estado" name="estado">
        <option value="">Todos</option>
        <option value="Ocupada" <?= $estado === 'Ocupada' ? 'selected' : '' ?>>Ocupada</option>
        <option value="Libre" <?= $estado === 'Libre' ? 'selected' : '' ?>>Libre</option>
    </select>

    <label for="id_sala">Sala:</label>
    <select id="id_sala" name="id_sala">
        <option value="">Todas</option>
        <?php
        $salas = $con->query("SELECT id_sala, nombre FROM salas");
        while ($sala = $salas->fetch_assoc()) {
            $selected = $sala['id_sala'] == $idSala ? 'selected' : '';
            echo "<option value='{$sala['id_sala']}' $selected>{$sala['nombre']}</option>";
        }
        ?>
    </select>

    <label for="id_mesa">Mesa:</label>
    <select id="id_mesa" name="id_mesa">
        <option value="">Todas</option>
        <?php
        $mesas = $con->query("SELECT DISTINCT id_mesa FROM mesas");
        while ($mesa = $mesas->fetch_assoc()) {
            $selected = $mesa['id_mesa'] == $idMesa ? 'selected' : '';
            echo "<option value='{$mesa['id_mesa']}' $selected>{$mesa['id_mesa']}</option>";
        }
        ?>
    </select>

    <label for="capacidad_mesa">Capacidad Mesa:</label>
    <input type="number" id="capacidad_mesa" name="capacidad_mesa" min="1" value="<?= htmlspecialchars($capacidadMesa) ?>">

    <label for="sillas_ocupadas">Sillas Ocupadas:</label>
    <input type="number" id="sillas_ocupadas" name="sillas_ocupadas" min="1" value="<?= htmlspecialchars($sillasOcupadas) ?>">

    <button type="submit">Filtrar</button>
</form>

<table>
    <tr>
        <th>ID Ocupación</th>
        <th>Camarero</th>
        <th>Sala</th>
        <th>Mesa</th>
        <th>Capacidad Mesa</th>
        <th>Sillas Ocupadas</th>
        <th>Fecha Ocupación</th>
        <th>Fecha Libera</th>
        <th>Estado actual</th>
    </tr>
    <?php
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id_ocupacion']}</td>
                    <td>{$fila['camarero']}</td>
                    <td>{$fila['sala']}</td>
                    <td>{$fila['id_mesa']}</td>
                    <td>{$fila['capacidad_mesa']}</td>
                    <td>{$fila['sillas_ocupadas']}</td>
                    <td>{$fila['fecha_ocupacion']}</td>
                    <td>{$fila['fecha_libera']}</td>
                    <td>{$fila['estado']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
    }
    $con->close();
    ?>
</table>

</body>
</html>
