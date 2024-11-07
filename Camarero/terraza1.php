<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terraza 1</title>
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
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Contenedor para mostrar la imagen y los botones de las mesas -->
    <div class="image-container">
        <img id="displayedImage" src="../img/terraza1.jpg" alt="Terraza 1">
        <div id="mesaButtonsContainer"></div>
    </div>

    <script>
        const mesasConfig = [
            { top: '23%', left: '18%', label: 'Mesa 1', onclick: () => alert('Mesa 1 en Terraza 1') },
            { top: '23%', left: '72%', label: 'Mesa 2', onclick: () => alert('Mesa 2 en Terraza 1') },
            { top: '71%', left: '18%', label: 'Mesa 3', onclick: () => alert('Mesa 3 en Terraza 1') },
            { top: '71%', left: '72%', label: 'Mesa 4', onclick: () => alert('Mesa 4 en Terraza 1') }
        ];

        function loadButtons() {
            const buttonsContainer = document.getElementById('mesaButtonsContainer');
            mesasConfig.forEach((mesa) => {
                const button = document.createElement('button');
                button.className = 'mesa-button';
                button.style.top = mesa.top;
                button.style.left = mesa.left;
                button.innerText = mesa.label;
                button.onclick = mesa.onclick;
                buttonsContainer.appendChild(button);
            });
        }

        document.addEventListener("DOMContentLoaded", loadButtons);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-7r82R3sMKeU9DAStBbXzTc98O/YMNZ4eF9NLMb13K3uqo/W9Y5Hk4HaeQOG99UZ3" crossorigin="anonymous"></script>
</body>
</html>
