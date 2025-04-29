<?php
// Parte 1: Seguridad básica.
require_once(__DIR__ . '/../../../../config.php'); // Subimos 5 niveles desde mod/assign/feedback/ai hasta raíz para incluir config.php.

require_login(); // Asegurarnos que el usuario está logueado.

// Parte 2: Recuperar parámetros básicos necesarios.
$cmid = required_param('id', PARAM_INT); // El ID del course module (asignación). --- Si lo recupera de la url
$userid = optional_param('userid', 0, PARAM_INT); // El ID del estudiante (puede ser opcional). --- Si lo recupera de la url

// Obtener el contexto de la actividad.
$cm = get_coursemodule_from_id('assign', $cmid, 0, false, MUST_EXIST);
// Obtener también el curso relacionado.
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
// Establecer correctamente el contexto de la página.
$PAGE->set_cm($cm, $course);
$PAGE->set_context(context_module::instance($cm->id));



// Parte 3: Configurar la página.
$PAGE->set_url(new moodle_url('/mod/assign/feedback/ai/feedback.php', ['id' => $cmid, 'userid' => $userid]));
$PAGE->set_title(get_string('pluginname', 'assignfeedback_ai'));
$PAGE->set_heading(get_string('pluginname', 'assignfeedback_ai'));
$PAGE->set_pagelayout('standard');

// Parte 4: Instanciar el formulario de IA.
require_once($CFG->dirroot . '/mod/assign/feedback/ai/classes/form/aiform.php');

$formdata = ['id' => $cmid, 'userid' => $userid];
$mform = new \assignfeedback_ai\form\ai_form(null, $formdata);

// Parte 5: Procesar el formulario.
if ($mform->is_cancelled()) {
    // Si el usuario cancela, redirigimos a la tarea.
    redirect(new moodle_url('/mod/assign/view.php', ['id' => $cmid]));
} else if ($data = $mform->get_data()) {
    // Si envió datos válidos:
    
    // Aquí podrías hacer la llamada a tu IA o guardar algo en la BD.
    // De momento solo mostramos el contenido enviado.
    echo $OUTPUT->header();
    echo html_writer::tag('h3', 'Data submitted:');
    echo html_writer::alist((array)$data);
    echo $OUTPUT->footer();
    exit; // Terminar para que no siga mostrando el form.
}

// Parte 6: Mostrar el formulario si no ha sido enviado aún.
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
