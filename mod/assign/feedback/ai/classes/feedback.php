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
        global $DB;

        if (!empty($data->instructions)) {
            $record = new \stdClass();
            $record->gradeid = $grade->id;
            $record->instructions = $data->instructions;
            $DB->insert_record('assignfeedback_ai', $record);
        }

        return true;
    }

    /**
     * Muestra contenido extra cuando el profesor está calificando (por ejemplo, el botón AI Grading).
     */
    public function view($grade, $submission) {
        global $PAGE, $USER, $OUTPUT;

        // Construir URL hacia nuestro feedback.php personalizado.
        $params = [
            'id' => $this->assignment->get_course_module()->id,  // cmid (assign instance)
            'userid' => $submission->userid                      // usuario a calificar
        ];
        $url = new \moodle_url('/mod/assign/feedback/ai/feedback.php', $params);

        // Crear el botón de enlace.
        $button = \html_writer::link(
            $url,
            get_string('aigrading', 'assignfeedback_ai'), // Texto del botón.
            ['class' => 'btn btn-primary'] // Bootstrap para estilo bonito.
        );

        // Devolver el botón como contenido.
        return $OUTPUT->container($button, 'assignfeedback_ai_button');
    }
}
