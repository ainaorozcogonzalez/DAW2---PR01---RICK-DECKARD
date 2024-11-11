<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privada 1</title>
    <!-- Incluir SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
</head>

<body id="bodyGen">
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container">
            <a href="./manager_home.php">
                <img id="LogoNav" src="../img/LOGO-REST.png" />
            </a>
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./manager_home.php">Inicio</a>
                    </li>
                </ul>
                <div id="divSession">
                    <h4>Bienvenid@ <?php echo htmlspecialchars($_SESSION['nombre']); ?></h4>
                </div>
                <div class="d-flex align-items-center">
                    <a href="../CerrarSesion.php" class="btn btn-primary me-3">
                        Cerrar sesión
                    </a>
                </div>
                <div>
                    <button id="volverBtn" class="btn btn-secondary">Volver</button>
                </div>
            </div>
        </div>
    </nav>
    <!-- Contenedor para mostrar la imagen y los botones de las mesas -->
    <div class="image-container">
        <img id="displayedImage" src="../img/priv1.jpg" alt="Privada 1">
        <div id="mesaButtonsContainer"></div>
    </div>
    <script src="../Js/volver.js"></script>
    <script src= "../Js/6mesas.js"></script>
</body>

</html>