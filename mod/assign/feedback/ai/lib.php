<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Extiende la navegación de settings para agregar AI Grading en la tarea.
 *
 * @param settings_navigation $settings
 * @param navigation_node $assignmentnode
 */
function assignfeedback_ai_extend_settings_navigation(settings_navigation $settings, navigation_node $assignmentnode) {
    global $PAGE;

    if ($PAGE->cm && $PAGE->cm->modname === 'assign') {
        $url = new moodle_url('/mod/assign/feedback/ai/feedback.php', [
            'id' => $PAGE->cm->id,
        ]);
        $assignmentnode->add(
            get_string('aigrading', 'assignfeedback_ai'), // Texto del enlace
            $url,
            navigation_node::TYPE_SETTING, // Tipo de nodo
            null,
            'assignfeedback_ai', // Identificador único del nodo
            new pix_icon('i/grades', '') // Ícono (opcional)
        );
    }
}

/**
 * Indica si el plugin de feedback AI está habilitado.
 *
 * @return bool
 */
function assignfeedback_ai_is_enabled() {
    return true;
}
