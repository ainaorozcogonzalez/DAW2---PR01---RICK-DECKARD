const mesasConfig = [
    { id:43, top: '16.5%', left: '10%', label: 'Mesa 1'},
    { id:44,top: '16.5%', left: '45%', label: 'Mesa 2'},
    { id:45,top: '16.5%', left: '79%', label: 'Mesa 3'},
    {id:46, top: '47%', left: '10%', label: 'Mesa 4'},
    { id:47,top: '47%', left: '45%', label: 'Mesa 5'},
    { id:48,top: '47%', left: '79%', label: 'Mesa 6'},
    {id:49, top: '76%', left: '10%', label: 'Mesa 7'},
    { id:50, top: '76%', left: '45%', label: 'Mesa 8'},
    { id:51, top: '76%', left: '79%', label: 'Mesa 9'}

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
    button.setAttribute('data-id', mesa.id);  // Asignar ID de la mesa al botón

    // Obtener el estado de la mesa desde la base de datos
    fetch(`obtener_estado_mesa.php?id_mesa=${mesa.id}`)
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'ocupada') {
                button.classList.add('ocupada');  // Cambiar a rojo
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

// Función para cambiar el estado de la mesa (ocupada o libre)
function toggleMesaState(id, button) {
const estado = button.classList.contains('ocupada') ? 'libre' : 'ocupada';

// Actualizar el estado de la mesa en la base de datos
fetch('actualizar_estado_mesa.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded', // Usamos urlencoded
    },
    body: `id_mesa=${id}&estado=${estado}` // Enviamos los datos por POST
})
.then(response => response.json())
.then(data => {
    if (estado === 'ocupada') {
        button.classList.add('ocupada'); // Cambiar a rojo
    } else {
        button.classList.remove('ocupada'); // Cambiar a verde
    }
    console.log(data.message);
})
.catch(error => {
    console.error('Error al actualizar el estado de la mesa:', error);
});
}

document.addEventListener("DOMContentLoaded", loadButtons);

