<?php
namespace local_greetings\form; // php asume que todo el codigo o lo que esté dentro de este namespace se ubica en esta ruta
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

class message_form extends \moodleform { //  " \moodleform le dice a PHP que no busque en este namespace sino en el espacio global"

   /**
     * Define the form.
     */
    public function definition() {
        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('textarea', 'message', get_string('yourmessage', 'local_greetings')); // Parametros (tipo de campo, nombre del campo q sera usado para recoger datos después, texto que aparece en el formulario)
        $mform->setType('message', PARAM_TEXT); // setType lo primero que hace es limpiar lo que el usuario escribio (posiblemente inyeccion de JS) y valida el campo q se espera 

        $submitlabel = get_string('submit'); // Para internacionalizar
        $mform->addElement('submit', 'submitmessage', $submitlabel);
    }

}