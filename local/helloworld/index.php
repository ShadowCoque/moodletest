<?php
require_once('../../config.php');

$courseid = required_param('id', PARAM_INT);
$course = get_course($courseid);
require_login($course);

$context = context_course::instance($course->id);
require_capability('local/helloworld:view', $context);

$PAGE->set_url(new moodle_url('/local/helloworld/index.php', ['id' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title("Hello Mundillo");
$PAGE->set_heading(get_string('pluginname', 'local_helloworld'));

//$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('message', 'local_helloworld'));
echo $OUTPUT->footer();

