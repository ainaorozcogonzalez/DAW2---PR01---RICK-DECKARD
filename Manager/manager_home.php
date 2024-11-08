<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body id="bodyMan">
    <div id="ocultarImg" class="">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar sala</h1>
            <div class="image-container">
                <a href="" id="Comedor">
                    <h3 class="text-overlay Comedor">Comedor</h3>
                    <img class="imgMan Comedor" src="../img/ComedorBtn.jpg" alt="Comedor">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Privada">
                    <h3 class="text-overlay Privada">Privada</h3>
                    <img class="imgMan Privada" src="../img/PrivadaBtn.png" alt="Privada">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Terraza">
                    <h3 class="text-overlay Terraza">Terraza</h3>
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
                    <a href="" id="Comedor">
                        <h3 class="text-overlay Comedor">Comedor 1</h3>
                        <img class="imgComedor" src="../img/Comedores.png" alt="Comedor">
                    </a>
                </div>
                <div class="image-container">
                    <a href="" id="Privada">
                        <h3 class="text-overlay Privada">Comedor 2</h3>
                        <img class="imgComedor" src="../img/Comedores.png" alt="Privada">
                    </a>
                </div>
                <button id="volverComedor" class="volverBtn">Volver</button>
            </div>

        </div>
    </div>
    <!-- Mostrar Salas Privadas -->
    <div id="Privadas" class="content">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar Sala Privada</h1>
            <div class="flex">
                <div class="image-container">
                    <a href="" id="Comedor">
                        <h3 class="text-overlay Comedor">Privada 1</h3>
                        <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Comedor">
                    </a>
                </div>
                <div class="image-container">
                    <a href="" id="Privada">
                        <h3 class="text-overlay Privada">Privada 2</h3>
                        <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Privada">
                    </a>
                </div>
            </div>
        </div>
        <div class="column-1 flex">
            <div class="image-container">
                <a href="" id="Terraza">
                    <h3 class="text-overlay Terraza">Privada 3</h3>
                    <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Terraza">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Terraza">
                    <h3 class="text-overlay Terraza">Privada 4</h3>
                    <img class="imgSalaPriv" src="../img/SalasPrivadas.png" alt="Terraza">
                </a>
            </div>
        </div>

        <button id="volverPrivada" class="volverBtn">Volver</button>
    </div>
    <!-- Mostrar Terrazas -->
    <div id="Terrazas" class="content">
        <div class="column-1">
            <h1 id="h1Sel">Seleccionar Terraza</h1>
            <div class="image-container">
                <a href="" id="Comedor">
                    <h3 class="text-overlay Comedor">Terraza 1</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Comedor">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Privada">
                    <h3 class="text-overlay Privada">Terraza 2</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Privada">
                </a>
            </div>
            <div class="image-container">
                <a href="" id="Terraza">
                    <h3 class="text-overlay Terraza">Terraza 3</h3>
                    <img class="imgTerraza" src="../img/Terrazas.png" alt="Terraza">
                </a>
            </div>
            <button id="volverTerraza" class="volverBtn">Volver</button>
        </div>
    </div>

    <script src="../Js/MostMesas.js"></script>

</body>

</html>