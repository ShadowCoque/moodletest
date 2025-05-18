<?php

namespace assignfeedback_ai\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class aiform extends \moodleform {
    public function definition() {
        $mform = $this->_form;

        // Enunciado del problema
        $mform->addElement('textarea', 'description', get_string('description', 'assignfeedback_ai'), 'wrap="virtual" rows="5" cols="80"');
        $mform->setType('description', PARAM_TEXT);

        // Rúbricas
        $mform->addElement('textarea', 'rubric', get_string('rubric', 'assignfeedback_ai'), 'wrap="virtual" rows="5" cols="80"');
        $mform->setType('rubric', PARAM_TEXT);

        // Filepicker solo acepta un archivo, filemanager acepta varios archivos
        // Soluciones correctas (filemanager)
        $mform->addElement('filemanager', 'solutionfiles', get_string('solution', 'assignfeedback_ai'), null, [
            'subdirs' => 0,
            'maxbytes' => 10485760, // 10 MB
            'maxfiles' => 5,
            'accepted_types' => '*',
        ]);

        // Entrenamiento al modelo (filemanager)
        $mform->addElement('filemanager', 'trainingfiles', get_string('training', 'assignfeedback_ai'), null, [
            'subdirs' => 0,
            'maxbytes' => 10485760,
            'maxfiles' => 5,
            'accepted_types' => '*',
        ]);

        // Retroalimentación (visualización simulada, no editable)
        $mform->addElement('static', 'feedbacksummary', get_string('feedbacksummary', 'assignfeedback_ai'), get_string('nofeedbackyet', 'assignfeedback_ai'));

        // ¿Está satisfecho con la nota?
        $mform->addElement('html', '<p>' . get_string('satisfiedquestion', 'assignfeedback_ai') . '</p>');
        $mform->addElement('submit', 'satisfiedyes', get_string('yes'));
        $mform->addElement('submit', 'satisfiedno', get_string('no'));
    }
}
