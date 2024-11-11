<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comedor 1</title>
    <style>
        .image-container {
            position: relative;
            text-align: center;
            margin-top: 20px;
            display: inline-block;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
        }
        .mesa-button {
            position: absolute;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #28a745; /* verde por defecto (libre) */
            color: white;
            border: none;
            cursor: pointer;
        }
        .mesa-button.ocupada {
            background-color: #dc3545; /* rojo cuando está ocupada */
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./CSS/salas.css">

</head>
<body>


    <!-- Contenedor para mostrar la imagen y los botones de las mesas -->
    <div class="image-container">
        <img id="displayedImage" src="../img/comedor1.jpg" alt="Terraza 1">
        <div id="mesaButtonsContainer"></div>
    </div>

    <script src= "../Js/9mesas.js"></script>
</body>
