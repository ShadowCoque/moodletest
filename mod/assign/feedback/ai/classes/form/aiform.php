<?php
namespace assignfeedback_ai\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

class ai_form extends \moodleform {
    public function definition() {
        $mform = $this->_form;

        // Un campo de texto para ingresar instrucciones a la IA.
        $mform->addElement('textarea', 'instructions', get_string('instructions', 'assignfeedback_ai'));
        $mform->setType('instructions', PARAM_TEXT);

        // Un botón de submit.
        $mform->addElement('submit', 'submitbutton', get_string('sendtoai', 'assignfeedback_ai'));
    }
}