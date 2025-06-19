<?php
// para tener acceso a la configuracion de moodle de manera global
/**
 * Esta línea importa toda la configuración y funciones globales de Moodle,
 * incluyendo el objeto $PAGE, $OUTPUT, funciones como get_string(),
 * y garantiza que todo esté inicializado correctamente.
 */
require_once('../../config.php');


// Obtiene el parámetro 'course_id' de la URL usando la función segura de Moodle.
// 'required_param' asegura que el parámetro sea obligatorio y del tipo esperado (entero).
// Si no se encuentra, Moodle lanza un error.
// Ejemplo: index.php?course_id=5 → $courseid será 5
//$courseid = required_param('course_id', PARAM_INT);
// se va a trabajar con optional_param que busca tanto en GET como en POST (formulario). (nombre del parámetro, valor por defecto, tipo de dato esperado)
$courseid = optional_param('course_id', 0, PARAM_INT);
$course = get_course($courseid); //obtiene el curso con el id especificado a partir de la funcion get_course() propia de Moodle
require_login($course); // Verifica que el usuario esté loggeado y tenga permiso para ver el curso especificado, si no, se redirige a la página de inicio de Moodle.

// Establece el contexto de la página como el contexto del curso actual, 
//permite que funciones como has_capability() evalúen correctamente dentro de este contexto.
$PAGE->set_context(context_course::instance($course->id)); 
$PAGE->set_url(new moodle_url('/local/procalculator/index.php', ['course_id' => $course->id])); //indica cual es la url de la pagina actual y se tiene que definir si o si 
$PAGE->set_title(get_string('pluginname', 'local_procalculator')); //Establece el titulo de la pagina actual



/* FORMULARIO */
//require_once($CFG->dirroot.'/local/procalculator/classes/form/calculator_form.php'); // se incluye el archivo del formulario 
$calculatorform = new \local_procalculator\form\calculator_form(); // se instancia el formulario

// // Procesamiento del formulario: si se envió y es válido
// if ($calculatorform->is_cancelled()) {
//     // Si se presionó el botón "Cancelar", podrías redirigir a otra página
//     redirect(new moodle_url('/facebook.com'));
// } else if ($data = $calculatorform->get_data()) {
//     // Si el formulario fue enviado y es válido (pasó validación)
//     echo $OUTPUT->header();
//     echo "Primer número: {$data->firstNumber} <br>";
//     echo "Segundo número: {$data->secondNumber} <br>";

//     // tener en cuenta que en el post moodle solo recupera el nombre del boton presuonado, asi que si uno se presiona, los demas no existiran
//     if($data->sumsubmit) {
//         echo 'Suma:' . $data->firstNumber + $data->secondNumber . '<br>';
//     }
//     if($data->substractsubmit) {
//         echo '--->'. $data->substractsubmit . '<br>';
//         echo 'Resta:' . $data->firstNumber - $data->secondNumber . '<br>';
//     }
//     if($data->multiplicationsubmit) {
//         echo '--->'. $data->multiplicationsubmit . '<br>';
//         echo 'Multiplicación:' . $data->firstNumber * $data->secondNumber . '<br>';
//     }
//     if($data->divisionsubmit) {
//         echo '--->'. $data->divisionsubmit . '<br>';
//         echo 'División:' . $data->firstNumber / $data->secondNumber . '<br>';
//     }
//     echo $OUTPUT->footer();
//     exit;
// }



// $PAGE->requires->js_init_code("
//     console.log('JS cargado correctamente del lado del cliente');
//     const formulario = document.getElementById('calculatorform');
    
//     function validateForm() {
//         let firstNumber = document.getElementById('firstNumber').value;
//         let secondNumber = document.getElementById('secondNumber').value;
//         if (firstNumber == '' || secondNumber == '') {
//             alert('Por favor, ingresa ambos números.');
//             return false;
//         }
//     }
    
//     formulario.addEventListener('submit', function(event) {
//         event.preventDefault();  // evita envío automático del formulario

//         const botonPresionado = event.submitter;
//         console.log('Nombre del botón:', botonPresionado.name);
//         console.log('Valor del botón:', botonPresionado.value);

//         if(botonPresionado.name == 'sumsubmit') {
//             document.getElementById('result').value = parseInt(document.getElementById('firstNumber').value) + parseInt(document.getElementById('secondNumber').value);
//         } else if(botonPresionado.name == 'substractsubmit') {
//             document.getElementById('result').value = parseInt(document.getElementById('firstNumber').value) - parseInt(document.getElementById('secondNumber').value);
//         } else if(botonPresionado.name == 'multiplicationsubmit') {
//             document.getElementById('result').value = parseInt(document.getElementById('firstNumber').value) * parseInt(document.getElementById('secondNumber').value);
//         } else if(botonPresionado.name == 'divisionsubmit') {
//             document.getElementById('result').value = parseInt(document.getElementById('firstNumber').value) / parseInt(document.getElementById('secondNumber').value);
//         }
//     });
// ");
$PAGE->requires->js_init_code("
    console.log('JS cargado correctamente del lado del cliente');

    const formulario = document.getElementById('calculatorform');
    const input1 = document.getElementById('id_firstNumber');
    const input2 = document.getElementById('id_secondNumber');
    const resultField = document.getElementById('id_result');

    formulario.addEventListener('submit', function(event) {
        event.preventDefault();  // evita el envío tradicional del formulario

        const botonPresionado = event.submitter;
        console.log('Nombre del botón:', botonPresionado.name);

        const num1 = parseFloat(input1.value);
        const num2 = parseFloat(input2.value);

        // Validación
        if (isNaN(num1) || isNaN(num2)) {
            alert('Por favor, ingresa ambos números.');
            return;
        }

        let resultado = '';

        switch (botonPresionado.name) {
            case 'sumsubmit':
                resultado = num1 + num2;
                break;
            case 'substractsubmit':
                resultado = num1 - num2;
                break;
            case 'multiplicationsubmit':
                resultado = num1 * num2;
                break;
            case 'divisionsubmit':
                if (num2 === 0) {
                    resultado = 'No se puede dividir por 0';
                } else {
                    resultado = num1 / num2;
                }
                break;
        }

        resultField.value = resultado;
    });
");

// $OUTPUT es un objeto global proporcionado por Moodle (instancia de core_renderer)
// que contiene métodos para renderizar partes de la página HTML (cabecera, pie, notificaciones, etc).
// El signo $ indica que es una variable en PHP.
// header() genera la cabecera HTML estándar de Moodle: <html>, <head>, <body> y estilos.
echo $OUTPUT->header();
// get_string() busca el texto traducido del archivo de idioma del plugin (lang/en/local_procalculator.php)
echo '<h1>' . get_string('pluginname', 'local_procalculator') .'</h1>';
echo '<p>' . get_string('description', 'local_procalculator') .'</p>';
$calculatorform->display();
// $OUTPUT->footer() imprime el cierre del HTML generado por Moodle (</body></html> y scripts JS incluidos).
// echo '<script>
//     console.log("JS cargado correctamente del lado del cliente");
//     const formulario = document.getElementById("calculatorform");
    
//     function validateForm() {
//         let firstNumber = document.getElementById("firstNumber").value;
//         let secondNumber = document.getElementById("secondNumber").value;
//         if (firstNumber == "" || secondNumber == "") {
//             alert("Por favor, ingresa ambos números.");
//             return false;
//         }
//         if()
//     }
    
//     formulario.addEventListener("submit", function(event) {
//         event.preventDefault();  // evita envío automático del formulario

//         const botonPresionado = event.submitter;
//         console.log("Nombre del botón:", botonPresionado.name);
//         console.log("Valor del botón:", botonPresionado.value);

//         if(botonPresionado.name == "sumsubmit") {
//             document.getElementById("result").value = parseInt(document.getElementById("firstNumber").value) + parseInt(document.getElementById("secondNumber").value);
//         } else if(botonPresionado.name == "substractsubmit") {
//             document.getElementById("result").value = parseInt(document.getElementById("firstNumber").value) - parseInt(document.getElementById("secondNumber").value);
//         } else if(botonPresionado.name == "multiplicationsubmit") {
//             document.getElementById("result").value = parseInt(document.getElementById("firstNumber").value) * parseInt(document.getElementById("secondNumber").value);
//         } else if(botonPresionado.name == "divisionsubmit") {
//             document.getElementById("result").value = parseInt(document.getElementById("firstNumber").value) / parseInt(document.getElementById("secondNumber").value);
//         }
//     });
// </script>';
echo $OUTPUT->footer();