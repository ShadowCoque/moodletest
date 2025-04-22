<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Agrega el enlace de la calculadora al menú del curso (pestaña "More").
 */
function local_helloworld_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('local/helloworld:view', $context)) {
        $url = new moodle_url('/local/helloworld/index.php', ['id' => $course->id]);
        $node = navigation_node::create(
            get_string('linktext', 'local_helloworld'), // Texto del enlace
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'local_helloworld'
        );
        $navigation->add_node($node);
    }
}
