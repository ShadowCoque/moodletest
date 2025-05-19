<?php

require('../../config.php');
require_once($CFG->dirroot . '/local/aigrading/classes/form/aiform.php');

$courseid = required_param('courseid', PARAM_INT);
$rewrite = optional_param('rewrite_rubric', 0, PARAM_BOOL); // Bandera para saber si modificar la rúbrica

$course = get_course($courseid);
require_login($course);
$context = context_course::instance($courseid);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/aigrading/index.php', ['courseid' => $courseid]));
$PAGE->set_title(get_string('pluginname', 'local_aigrading'));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

// Instancia inicial del formulario
$mform = new \local_aigrading\form\aiform();
$mform->set_data((object)['courseid' => $courseid]); // ⚠️ Incluir courseid en cada caso

// Cancelar formulario
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));

} else if ($data = $mform->get_data()) {
    if (isset($data->satisfiedno)) {
        // Redirigir con bandera para reescribir la rúbrica
        $url = new moodle_url('/local/aigrading/index.php', [
            'courseid' => $courseid,
            'rewrite_rubric' => 1
        ]);
        redirect($url);
    }

    // Si presionó "Sí" u otro botón
    echo $OUTPUT->header();
    echo html_writer::tag('h3', 'Datos enviados por el usuario:');
    echo html_writer::alist((array)$data);
    echo $OUTPUT->footer();
    exit;
}

// Si se solicitó actualizar la rúbrica
if ($rewrite) {
    $feedback = get_string('nofeedbackyet', 'local_aigrading'); // Esto será reemplazado por IA más adelante
    $mensaje = "La retroalimentación que tú me diste fue \"$feedback\", pero no me pareció del todo correcta. Podríamos mejorar en ...";

    $datos = (object)[
        'rubric' => $mensaje,
        'feedbacksummary' => $feedback,
        'courseid' => $courseid
    ];

    $mform->set_data($datos);
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
