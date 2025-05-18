<?php
// Este archivo es parte del plugin assignfeedback_ai.
// Muestra y procesa el formulario personalizado con archivos y opciones de evaluación por IA.

require_once('../../../../config.php');
require_once($CFG->dirroot . '/mod/assign/feedback/ai/classes/form/aiform.php');

$id = required_param('id', PARAM_INT);        // ID del módulo (asignación).
$userid = optional_param('userid', 0, PARAM_INT); // ID del estudiante (opcional por ahora).

// Obtener información del módulo y del curso.
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course); // <- NECESARIO para evitar errores
$context = context_module::instance($cm->id);

// Validar que el usuario haya iniciado sesión y tenga acceso al módulo.
require_login($course, false, $cm);

// Configurar la página con el cm y el curso.
$PAGE->set_cm($cm, $course); // <- Esta línea es crucial para navegación
$PAGE->set_url(new moodle_url('/mod/assign/feedback/ai/feedback.php', ['id' => $id, 'userid' => $userid]));
$PAGE->set_title(get_string('pluginname', 'assignfeedback_ai'));
$PAGE->set_heading(get_string('pluginname', 'assignfeedback_ai'));
$PAGE->set_pagelayout('standard');

// Instanciar el formulario.
$formdata = ['id' => $id, 'userid' => $userid, 'context' => $context];
$mform = new \assignfeedback_ai\form\aiform(null, $formdata);

// Procesamiento del formulario.
if ($mform->is_cancelled()) {
    // Si el formulario fue cancelado, redirige de vuelta a la tarea.
    redirect(new moodle_url('/mod/assign/view.php', ['id' => $id]));

} else if ($data = $mform->get_data()) {
    // Si los datos fueron enviados y validados correctamente:
    echo $OUTPUT->header();
    echo html_writer::tag('h3', 'Datos enviados por el usuario:');
    echo html_writer::alist((array)$data);
    echo $OUTPUT->footer();
    exit;
}

// Mostrar el formulario si aún no fue enviado.
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
