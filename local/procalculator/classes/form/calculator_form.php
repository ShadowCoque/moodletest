<?php
namespace local_procalculator\form; // define el namespace del formulario lo que permite que moodle lo reconozca y evite conflictos (convencion de Moodle)
defined('MOODLE_INTERNAL') || die(); // Previene el acceso directo al archivo desde el navegador con su URL

// $CFG es una variable global de Moodle que contiene rutas del sistema como libdir
require_once($CFG->libdir . '/formslib.php'); //se incluye la biblioteca principal de formularios de Moodle, misma que define la clase moodleform
// require_once(__DIR__ . '/../../../lib/formslib.php');

//nueva clase de formulario que hereda de moodleform ya establecida por moodle
class calculator_form extends \moodleform { //  " \moodleform le dice a PHP que no busque en este namespace sino en el espacio global

    // funcion definition es obligatoria y se sobreescribe para definir los elementos del formulario
    public function definition() {

        // $this->_form contiene el objeto mform (instancia de MoodleQuickForm), forma estándar de acceder al constructor de campos del formulario.
        $mform = $this->_form; // Don't forget the underscore!
        $mform->updateAttributes(['id' => 'calculatorform']);

        //Elemento texto para el primer numero
        $mform->addElement('text', 'firstNumber', get_string('firstnumber', 'local_procalculator')); // Parametros (tipo de campo, nombre del campo q sera usado para recoger datos después, texto que aparece en el formulario)
        $mform->setType('firstNumber', PARAM_FLOAT); // setType lo primero que hace es limpiar lo que el usuario escribio (posiblemente inyeccion de JS) y valida el campo q se espera 

        //Elemento texto para el segundo numero
        $mform->addElement('text', 'secondNumber', get_string('secondnumber', 'local_procalculator')); // Parametros (tipo de campo, nombre del campo q sera usado para recoger datos después, texto que aparece en el formulario)
        $mform->setType('secondNumber', PARAM_FLOAT); // setType lo primero que hace es limpiar lo que el usuario escribio (posiblemente inyeccion de JS) y valida el campo q se espera 

        //Boton para la operacion suma
        $mform->addElement('submit', 'sumsubmit', get_string('sum', 'local_procalculator'));

        //Boton para la operacion resta
        $mform->addElement('submit', 'substractsubmit', get_string('subtraction', 'local_procalculator'));

        //Boton para la operacion multiplicacion
        $mform->addElement('submit', 'multiplicationsubmit', get_string('multiplication', 'local_procalculator'));

        //Boton para la operacion division
        $mform->addElement('submit', 'divisionsubmit', get_string('division', 'local_procalculator'));

        // etiqueta para mostrar el resultado
        $mform->addElement('text', 'result', get_string('result', 'local_procalculator'));
        $mform->setType('result', PARAM_TEXT);
        //$mform->setAttributes(['readonly' => 'readonly', 'id' => 'resultado']); // para que no se pueda editar

        // Campo oculto para conservar el course_id
        $mform->addElement('hidden', 'course_id', optional_param('course_id', 0, PARAM_INT));
        $mform->setType('course_id', PARAM_INT);

    }

}