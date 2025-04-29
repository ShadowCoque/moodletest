<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Extiende el menú de navegación de ajustes para mostrar el enlace de AI Grading.
 *
 * @param settings_navigation $settingsnav
 * @param navigation_node $node
 */
function assignfeedback_ai_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $node) {
    global $PAGE;

    if (!has_capability('mod/assign:grade', $PAGE->context)) {
        return;
    }

    // Asegúrate de que tienes un cmid en la URL.
    $cmid = optional_param('id', 0, PARAM_INT);
    $userid = optional_param('userid', 0, PARAM_INT); // Puedes pasarlo por la URL si es necesario.

    if (!$cmid) {
        return;
    }

    // Construir URL del formulario AI.
    $url = new moodle_url('/mod/assign/feedback/ai/feedback.php', [
        'id' => $cmid,
        'userid' => $userid
    ]);

    $linkname = get_string('aigrading', 'assignfeedback_ai');

    // Agregar el nodo dentro del menú "More" (settingsnav).
    $node->add(
        $linkname,
        $url,
        navigation_node::TYPE_SETTING,
        null,
        'assignfeedback_ai_link',
        new pix_icon('i/settings', '')
    );
}
