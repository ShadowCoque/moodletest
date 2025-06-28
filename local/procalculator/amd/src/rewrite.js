/** Este archivo se encargara de
 * capturar el evento click en los botones
 * obtener los valores del formulario
 * usar $.ajax() para enviar los datos al servidor (ajax.php)
 * mostrar la respuesta del servidor en el navegador
 */
// se genera un rewrite.min.js que es el JS optimizado que si utilizara moodle (minificado, es decir, mas rapido de cargar)
//grunt es un compilador, automatizador y minificador de JS


// Declaramos el módulo AMD, importando jQuery como dependencia.
// Esta estructura es requerida por Moodle para reconocer el JS como un módulo AMD.
define(['jquery'], function($) {
    console.log('Se ha iniciado el rewrite.js');
    // Función auxiliar que obtiene el parámetro courseid desde la URL
    function getCourseIdFromUrl() {
        return new URLSearchParams(window.location.search).get('course_id');
    }

    // Retornamos el objeto que expone la función init()
    return {
        init: function() {
            // Escuchamos el evento de envío del formulario
            $('#calculatorform').on('submit', function(e) {
                e.preventDefault(); // Evita que se envíe de forma tradicional (HTML POST)

                // Obtenemos el botón que disparó el submit
                const botonPresionado = e.originalEvent.submitter;

                // Extraemos los valores de los campos del formulario
                const firstNumber = $('#id_firstNumber').val();
                const secondNumber = $('#id_secondNumber').val();

                // Validación: si alguno de los campos está vacío, mostramos alerta y detenemos ejecución
                if (firstNumber === '' || secondNumber === '') {
                    alert('Por favor, ingresa ambos números.');
                    return;
                }

                // Extraemos el nombre del botón (sumsubmit, substractsubmit, etc.)
                const operacion = botonPresionado.name;

                // Obtenemos el course_id desde la URL y la sesskey desde Moodle (necesario por seguridad)
                const courseid = Number(getCourseIdFromUrl());
                const sesskey = M.cfg.sesskey;

                // Enviamos los datos mediante AJAX al archivo PHP en el servidor
                $.ajax({
                    method: 'POST',
                    url: M.cfg.wwwroot + '/local/procalculator/ajax.php',
                    data: {
                        firstNumber: Number(firstNumber),
                        secondNumber: Number(secondNumber),
                        operacion: operacion,
                        courseid: courseid,
                        sesskey: sesskey
                    },
                    success: function(response) {
                        if (response.success) {
                            // Si la respuesta es exitosa, mostramos el resultado en el campo 'result'
                            //$('#id_result').text(response.resultado);
                            $('#id_result').val(response.resultado); // si es input
                            console.log('Operacion solicitada con valor:', response);
                        } else {
                            alert('Error al procesar la operación.');
                        }
                    },
                    error: function(xhr) {
                        alert('Error del servidor: ' + xhr.status);
                    }
                });
            });
        }
    };
});
