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

// Carga el módulo JS que escucha el botón "No" y usa AJAX
$PAGE->requires->js_call_amd('local_aigrading/rewrite', 'init');

// Crear e inicializar el formulario
$mform = new \local_aigrading\form\aiform();
$mform->set_data((object)['courseid' => $courseid]);

// Manejo de cancelación
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));
}

// Manejo de envío (por ejemplo, si presiona “Sí”)
else if ($data = $mform->get_data()) {
    if (isset($data->satisfiedyes)) {
        echo $OUTPUT->header();
        echo html_writer::tag('h3', 'Datos enviados por el usuario:');
        echo html_writer::alist((array)$data);
        echo $OUTPUT->footer();
        exit;
    }

    // Si presiona “No”, ya no se redirige, lo maneja JS con AJAX.
}

// Mostrar el formulario
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
