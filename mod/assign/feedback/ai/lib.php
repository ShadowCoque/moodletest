<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Extiende la navegación de settings de la tarea.
 *
 * @param settings_navigation $settingsnav
 * @param navigation_node $node
 */
function assignfeedback_ai_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $node) {
    global $PAGE, $USER;

    if ($PAGE->cm->modname !== 'assign' || !has_capability('mod/assign:grade', $PAGE->context)) {
        return;
    }

    $url = new moodle_url('/mod/assign/feedback/ai/feedback.php', [
        'id' => $PAGE->cm->id,
        'userid' => $USER->id,
    ]);

    $node->add(
        get_string('aigrading', 'assignfeedback_ai'), // Nombre visible del botón.
        $url,
        navigation_node::TYPE_SETTING,
        null,
        null,
        new pix_icon('i/settings', '') // Un ícono estándar de engranaje (opcional).
    );
}
