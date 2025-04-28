<?php

namespace assignfeedback_ai;

defined('MOODLE_INTERNAL') || die();

class feedback extends \assign_feedback_plugin {

    public function get_form_elements($submission, \MoodleQuickForm $mform, \stdClass $data) {
        $mform->addElement('header', 'aiheader', get_string('aigrading', 'assignfeedback_ai'));

        $mform->addElement('textarea', 'instructions', get_string('instructions', 'assignfeedback_ai'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('instructions', PARAM_TEXT);

        return true; // Muy importante devolver true
    }

    public function save(\stdClass $grade, \stdClass $data) {
        // Aquí deberías guardar los datos recibidos.
        global $DB;

        if (!empty($data->instructions)) {
            $record = new \stdClass();
            $record->gradeid = $grade->id;
            $record->instructions = $data->instructions;
            $DB->insert_record('assignfeedback_ai', $record);
        }

        return true;
    }
}
