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
    <title>Comedor 1</title>
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
        <img id="displayedImage" src="../img/comedor1.jpg" alt="Terraza 1">
        <div id="mesaButtonsContainer"></div>
    </div>

    <script>
        // Configuración de las mesas con sus posiciones y etiquetas
        const mesasConfig = [{
                id: 20,
                top: '16.5%',
                left: '10%',
                label: 'Mesa 1'
            },
            {
                id: 21,
                top: '16.5%',
                left: '45%',
                label: 'Mesa 2'
            },
            {
                id: 22,
                top: '16.5%',
                left: '79%',
                label: 'Mesa 3'
            },
            {
                id: 23,
                top: '47%',
                left: '10%',
                label: 'Mesa 4'
            },
            {
                id: 24,
                top: '47%',
                left: '45%',
                label: 'Mesa 5'
            },
            {
                id: 25,
                top: '47%',
                left: '79%',
                label: 'Mesa 6'
            },
            {
                id: 26,
                top: '76%',
                left: '10%',
                label: 'Mesa 7'
            },
            {
                id: 27,
                top: '76%',
                left: '45%',
                label: 'Mesa 8'
            },
            {
                id: 28,
                top: '76%',
                left: '79%',
                label: 'Mesa 9'
            }
        ];

        // Función para cargar los botones con su estado
        function loadButtons() {
            const buttonsContainer = document.getElementById('mesaButtonsContainer');

            mesasConfig.forEach((mesa) => {
                const button = document.createElement('button');
                button.className = 'mesa-button';
                button.style.top = mesa.top;
                button.style.left = mesa.left;
                button.innerText = mesa.label;
                button.setAttribute('data-id', mesa.id); // Asignar ID de la mesa al botón

                // Obtener el estado de la mesa desde la base de datos
                fetch(`obtener_estado_mesa.php?id_mesa=${mesa.id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.estado === 'ocupada') {
                            button.classList.add('ocupada'); // Cambiar a rojo
                        }
                    })
                    .catch(error => console.error('Error al obtener el estado de la mesa:', error));

                // Función al hacer clic en el botón
                button.onclick = function() {
                    toggleMesaState(mesa.id, button);
                };

                buttonsContainer.appendChild(button);
            });
        }

        // Función para cambiar el estado de la mesa (ocupada o libre) y pedir el número de sillas usando SweetAlert
        function toggleMesaState(id, button) {
            const estado = button.classList.contains('ocupada') ? 'libre' : 'ocupada';

            if (estado === 'ocupada') {
                // Solicitar el número de sillas si se va a ocupar la mesa
                Swal.fire({
                    title: 'Ingrese el número de sillas necesarias para esta mesa:',
                    input: 'number',
                    inputAttributes: {
                        min: 1,
                        max: 6,
                        step: 1
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Debe ingresar un número de sillas.';
                        } else if (value < 1 || value > 6) {
                            return 'Por favor, ingrese un número de sillas entre 1 y 6.';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const sillas = parseInt(result.value);

                        // Actualizar el estado de la mesa en la base de datos
                        fetch('actualizar_estado_mesa.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `id_mesa=${id}&estado=${estado}&sillas=${sillas}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                button.classList.add('ocupada'); // Cambiar a rojo
                                console.log(data.message);
                            })
                            .catch(error => {
                                console.error('Error al actualizar el estado de la mesa:', error);
                            });
                    }
                });
            } else {
                // Cambiar a libre sin pedir número de sillas
                fetch('actualizar_estado_mesa.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_mesa=${id}&estado=${estado}&sillas=0`
                    })
                    .then(response => response.json())
                    .then(data => {
                        button.classList.remove('ocupada'); // Cambiar a verde
                        console.log(data.message);
                    })
                    .catch(error => {
                        console.error('Error al actualizar el estado de la mesa:', error);
                    });
            }
        }

        document.addEventListener("DOMContentLoaded", loadButtons);
    </script>
    <script src="../Js/volver.js"></script>
</body>

</html>