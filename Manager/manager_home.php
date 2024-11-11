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
    <title>Manager</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
</head>

<body id="bodyMan">
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container">
            <a href="./manager_home.php">
                <img id="LogoNav" src="../img/LOGO-REST.png" />
            </a>
            <div id="collapse" class="collapse navbar-collapse" id="navbarButtonsExample">
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
            </div>
        </div>
    </nav>
    <div id="ocultarImg" class="">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar sala</h1>
            <div class="image-container">
                <a href="" id="Comedor">
                    <h3 class="text-overlay">Comedor</h3>
                    <img class="imgMan Comedor" src="../img/ComedorBtn.jpg" alt="Comedor">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Privada">
                    <h3 class="text-overlay">Privada</h3>
                    <img class="imgMan Privada" src="../img/PrivadaBtn.png" alt="Privada">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Terraza">
                    <h3 class="text-overlay">Terraza</h3>
                    <img class="imgMan Terraza" src="../img/TerrazaBtn.png" alt="Terraza">
                </a>
            </div>
        </div>
    </div>
    <!-- Mostrar Comedores -->

    <div id="Comedores" class="content">
        <div class="column-1 flex">
            <div>
                <h1 id="h1Sel">Seleccionar Comedor</h1>
                <div class="image-container">
                    <a href="../Camarero/comedor1.php" id="Comedor">
                        <h3 class="text-overlay">Comedor 1</h3>
                        <img class="imgComedor" src="../img/Comedores.png" alt="Comedor">
                    </a>
                </div>
                <div class="image-container">
                    <a href="../Camarero/comedor2.php" id="Privada">
                        <h3 class="text-overlay">Comedor 2</h3>
                        <img class="imgComedor" src="../img/Comedores.png" alt="Privada">
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!-- Mostrar Salas Privadas -->
    <div id="Privadas" class="content">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar Sala Privada</h1>
            <div class="flex">
                <div class="image-container">
                    <a href="../Camarero/privada1.php" id="Comedor">
                        <h3 class="text-overlay">Privada 1</h3>
                        <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Comedor">
                    </a>
                </div>
                <div class="image-container">
                    <a href="../Camarero/privada2.php" id="Privada">
                        <h3 class="text-overlay">Privada 2</h3>
                        <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Privada">
                    </a>
                </div>
            </div>
        </div>
        <div class="column-1 flex">
            <div class="image-container">
                <a href="../Camarero/privada3.php" id="Terraza">
                    <h3 class="text-overlay">Privada 3</h3>
                    <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Terraza">
                </a>
            </div>
            <div class="image-container">
                <a href="../Camarero/privada4.php" id="Terraza">
                    <h3 class="text-overlay">Privada 4</h3>
                    <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Terraza">
                </a>
            </div>
        </div>
    </div>
    <!-- Mostrar Terrazas -->
    <div id="Terrazas" class="content">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar Terraza</h1>
            <div class="image-container">
                <a href="../Camarero/terraza1.php" id="Comedor">
                    <h3 class="text-overlay">Terraza 1</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Comedor">
                </a>
            </div>
            <div class="image-container">
                <a href="../Camarero/terraza2.php" id="Privada">
                    <h3 class="text-overlay">Terraza 2</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Privada">
                </a>
            </div>
            <div class="image-container">
                <a href="../Camarero/terraza3.php" id="Terraza">
                    <h3 class="text-overlay">Terraza 3</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Terraza">
                </a>
            </div>
        </div>
    </div>

    <script src="../Js/MostMesas.js"></script>

</body>

</html>