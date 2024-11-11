// Archivo: mesa.js
document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los botones de mesa
    document.querySelectorAll('.btn-mesa').forEach(button => {
        button.addEventListener('click', function() {
            const estado = this.dataset.estado; // Estado actual de la mesa
            const idMesa = this.dataset.id;     // ID de la mesa
            const capacidadMesa = parseInt(this.dataset.capacidad); // Capacidad máxima de la mesa

            if (estado === 'libre') {
                // Mostrar SweetAlert para pedir cantidad de sillas
                Swal.fire({
                    title: 'Número de sillas',
                    input: 'number',
                    inputLabel: `Ingrese el número de sillas (máximo ${capacidadMesa})`,
                    inputAttributes: {
                        min: 1,
                        max: capacidadMesa,
                        step: 1
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reservar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: (cantidad) => {
                        if (cantidad < 1 || cantidad > capacidadMesa) {
                            Swal.showValidationMessage(`Debe ingresar un número entre 1 y ${capacidadMesa}`);
                        }
                        return cantidad;
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        const sillas = result.value;

                        // Llamada AJAX para actualizar el estado y número de sillas
                        fetch('actualizar_estado_mesa.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id_mesa=${idMesa}&estado=ocupada&sillas=${sillas}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.estado === 'ocupada') {
                                Swal.fire('Mesa ocupada', `Mesa reservada con ${sillas} sillas`, 'success');
                                button.dataset.estado = 'ocupada';
                                button.classList.remove('btn-success');
                                button.classList.add('btn-danger');
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        });
                    }
                });
            } else {
                // Código para liberar la mesa, si es necesario.
            }
        });
    });
});
