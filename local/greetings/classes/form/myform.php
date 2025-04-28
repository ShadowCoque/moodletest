<?php
namespace local_greetings\form;
// moodleform is defined in formslib.php. This class has to extends moodleform and override definition() for include form elements
require_once("$CFG->libdir/formslib.php");

class myform extends \moodleform {
    // En este metodo sobreescrito se definen los elementos del formulario
    public function definition() {
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!
        // Add elements to your form.
        $mform->addElement('text', 'email', get_string('email'));
        // Set type of element.
        $mform->setType('email', PARAM_NOTAGS);
        // Default value.
        $mform->setDefault('email', 'Please enter email');
    }
    // Se puede definir validación personal y adicional para que los datos llenados en el formulario tengan sentido.
    function validation($data, $files) {
        return [];
    }
}