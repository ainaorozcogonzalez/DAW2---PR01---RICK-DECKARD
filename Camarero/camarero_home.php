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
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/terraza1.jpg')">Terraza 1</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/terraza2.jpg')">Terraza 2</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/terraza3.jpg')">Terraza 3</a></li>
                        </ul>
                    </li>
                    <!-- Menú Comedores -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="comedoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Comedores
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="comedoresDropdown">
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/comedor1.jpg')">Comedor 1</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/comedor1.jpg')">Comedor 2</a></li>
                        </ul>
                    </li>
                    <!-- Menú Salas Privadas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="salasPrivadasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Salas Privadas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="salasPrivadasDropdown">
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/priv1.jpg')">Sala Privada 1</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/priv2.jpg')">Sala Privada 2</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/priv3.jpg')">Sala Privada 3</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showImage('../img/priv4.jpg')">Sala Privada 4</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
