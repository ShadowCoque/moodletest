<?php

defined('MOODLE_INTERNAL') || die();

/*function local_aigrading_extend_navigation_course($navigation, $course, $context) {
    $url = new moodle_url('/local/aigrading/index.php', ['id' => $course->id]);
    $navigation->add(get_string('pluginname', 'local_aigrading'), $url, navigation_node::TYPE_CUSTOM);
}*/

function local_aigrading_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('/local/aigrading:view', $context)) {
        $url = new moodle_url('/local/aigrading/index.php', ['id' => $course->id]);
        $node = navigation_node::create(
            get_string('pluginname', 'local_aigrading'), // Texto del enlace
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'local_aigrading'
        );
        $navigation->add_node($node);
    }
}