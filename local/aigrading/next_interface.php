<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/local/aigrading/next_interface.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('AI Grading – Confirmation');
$PAGE->set_heading('Selected Students Overview');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('studentselection', 'local_aigrading'));

// Simulación de datos
$students = [
    [
        'name' => 'Mario Lopez',
        'feedback' => 'El número de tablas es correcto pero te confundiste al relacionar específicamente la tabla X con la tabla Y. Además, ...',
        'grade' => '8.5'
    ],
    // En el futuro: aquí puedes agregar más estudiantes dinámicamente
];

// Mostrar en tabla
echo html_writer::start_tag('table', ['class' => 'generaltable table table-striped']);
echo html_writer::start_tag('thead');
echo html_writer::tag('tr',
    html_writer::tag('th', 'Name') .
    html_writer::tag('th', 'AI Feedback') .
    html_writer::tag('th', 'Suggested Grade') .
    html_writer::tag('th', 'Actions')
);
echo html_writer::end_tag('thead');

echo html_writer::start_tag('tbody');
foreach ($students as $student) {
    //shorten_text es una función propia de Moodle que corta el texto y agrega un "..."
    $shortfeedback = shorten_text($student['feedback'], 50); // máximo 30 chars
    $row = html_writer::tag('td', $student['name']) .
           html_writer::tag('td', $shortfeedback) .
           html_writer::tag('td', $student['grade']) .
           html_writer::tag('td',
               html_writer::link('#', 'Check full feedback', ['class' => 'btn btn-secondary btn-sm'])
           );
    echo html_writer::tag('tr', $row);
}
echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo $OUTPUT->footer();
