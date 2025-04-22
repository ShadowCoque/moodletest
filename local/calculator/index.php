<?php
require_once('../../config.php');

$courseid = required_param('id', PARAM_INT);
$course = get_course($courseid);
require_login($course);

$context = context_course::instance($course->id);
require_capability('local/calculator:view', $context);

$PAGE->set_url(new moodle_url('/local/calculator/index.php', ['id' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_calculator'));
$PAGE->set_heading(get_string('pluginname', 'local_calculator'));

$sum = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n1 = required_param('number1', PARAM_FLOAT);
    $n2 = required_param('number2', PARAM_FLOAT);
    $sum = $n1 + $n2;
}

echo $OUTPUT->header();
echo html_writer::start_tag('form', ['method' => 'post']);

echo html_writer::label(get_string('number1', 'local_calculator'), 'number1');
echo html_writer::empty_tag('input', ['type' => 'text', 'name' => 'number1', 'id' => 'number1']);

echo html_writer::label(get_string('number2', 'local_calculator'), 'number2');
echo html_writer::empty_tag('input', ['type' => 'text', 'name' => 'number2', 'id' => 'number2']);

echo html_writer::empty_tag('br');
echo html_writer::empty_tag('br');

echo html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('sum', 'local_calculator')]);

echo html_writer::end_tag('form');

if ($sum !== '') {
    echo html_writer::tag('p', get_string('result', 'local_calculator') . ': ' . $sum);
}

echo $OUTPUT->footer();
