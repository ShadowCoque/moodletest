<?php
require('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$context = context_course::instance($courseid);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/aigrading/confirm.php', ['courseid' => $courseid]));
$PAGE->set_title("Confirmación");
$PAGE->set_heading("Confirmación");

echo $OUTPUT->header();
echo html_writer::tag('h2', 'Aquí se procesará la selección de estudiantes');
echo $OUTPUT->footer();
