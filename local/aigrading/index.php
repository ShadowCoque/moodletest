<?php

require('../../config.php');
require_once($CFG->dirroot . '/local/aigrading/classes/form/aiform.php');

$courseid = required_param('courseid', PARAM_INT);
$course = get_course($courseid);
require_login($course);
$context = context_course::instance($courseid);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/aigrading/index.php', ['courseid' => $courseid]));
$PAGE->set_title(get_string('pluginname', 'local_aigrading'));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

/*$mform = new \local_aigrading\form\aiform();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));

} else if ($data = $mform->get_data()) {
    echo $OUTPUT->header();
    echo html_writer::tag('h3', 'Datos enviados por el usuario:');
    echo html_writer::alist((array)$data);
    echo $OUTPUT->footer();
    exit;
}*/
$mform = new \local_aigrading\form\aiform();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));

} else if ($data = $mform->get_data()) {
    if (isset($data->satisfiedno)) {
        // Usuario presionó "No"
        $retroalimentacion = $data->feedbacksummary ?? get_string('nofeedbackyet', 'local_aigrading');
        $nuevarubrica = "La retroalimentación que tú me diste fue \"$retroalimentacion\", pero no me pareció del todo correcta. Podríamos mejorar en ...";

        // Cargar nueva instancia del formulario con la rúbrica modificada
        $data->rubric = $nuevarubrica;
        $mform = new \local_aigrading\form\aiform();
        $mform->set_data($data);
    } else {
        // Usuario presionó cualquier otro botón (por ejemplo "Yes"), o el envío general
        echo $OUTPUT->header();
        echo html_writer::tag('h3', 'Datos enviados por el usuario:');
        echo html_writer::alist((array)$data);
        echo $OUTPUT->footer();
        exit;
    }
}


echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
