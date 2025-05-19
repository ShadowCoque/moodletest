<?php

defined('MOODLE_INTERNAL') || die();

function local_aigrading_extend_navigation_course($navigation, $course, $context) {
    $url = new moodle_url('/local/aigrading/index.php', ['courseid' => $course->id]);
    $navigation->add(get_string('pluginname', 'local_aigrading'), $url, navigation_node::TYPE_CUSTOM);
}
