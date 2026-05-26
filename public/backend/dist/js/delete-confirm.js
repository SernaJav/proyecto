// =========================
// esperar carga de página
// =========================
$(document).ready(function () {

    // =========================
    // capturar formularios delete
    // =========================
    $('.delete-form').on('submit', function (e) {

        // =========================
        // detener envío normal
        // =========================
        e.preventDefault();

        // =========================
        // guardar formulario
        // =========================
        let form = this;

        // =========================
        // guardar posición de scroll antes de eliminar
        // =========================
        const scrollPos = $(window).scrollTop();

        // =========================
        // alerta moderna
        // =========================
        Swal.fire({

            title: '¿Eliminar registro?',

            html:
                `
                <div style="font-size:15px;">
                    Esta acción eliminará también:
                    <br><br>
                    <b>• pagos asociados</b><br>
                    <b>• detalles de compra</b>
                    <br><br>
                    Esta acción no se puede deshacer.
                </div>
                `,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Sí, eliminar',

            cancelButtonText: 'Cancelar',

            reverseButtons: true

        }).then((result) => {

            // =========================
            // confirmar eliminación
            // =========================
            if (result.isConfirmed) {

                // Guardar scroll antes de enviar
                sessionStorage.setItem('scrollPos', scrollPos);

                form.submit();
            }
        });
    });
});