<?php

/**
 * This file was updated to inject the Greetings plugin link into the navigation
 * of the assignment grading view instead of the front page.
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Adds a "Greetings" link to the assignment grading page if the user has grading permission.
 *
 * This replaces the previous extend_navigation_frontpage() hook to move the button
 * from the site front page to the assignment module context.
 *
 * @param navigation_node $navigation The current navigation tree
 * @param stdClass $course The course object
 * @param context_course $context The context of the course
 */

 function local_greetings_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_greetings'),
        new moodle_url('/local/greetings/index.php'),
        navigation_node::TYPE_CUSTOM,
    );
}
/*
function local_greetings_extend_navigation_course(navigation_node $navigation, stdClass $course, context_course $context) {
    global $PAGE;

    // Validar que estamos en una actividad tipo 'assign'.
    if (!isset($PAGE->cm) || $PAGE->cm->modname !== 'assign') {
        return; // No estamos dentro de una tarea.
    }

    // Verificar que el usuario tenga permiso para calificar esta actividad.
    if (!has_capability('mod/assign:grade', context_module::instance($PAGE->cm->id))) {
        return; // No tiene permisos para ver el link.
    }

    // Añadir el nodo "Greetings" al menú del módulo (como botón o enlace).
    $url = new moodle_url('/local/greetings/index.php', [
        'id' => $PAGE->cm->id, // Se puede usar para enlazar con la tarea actual
    ]);

    $navigation->add(
        get_string('pluginname', 'local_greetings'),
        $url,
        navigation_node::TYPE_CUSTOM
    );
}*/

/*function local_greetings_extend_settings_navigation(settings_navigation $settingsnav, context $context) {
    global $PAGE;

    // Asegúrate de que estamos en un módulo de actividad y que es una tarea.
    if (!$PAGE->cm || $PAGE->cm->modname !== 'assign') {
        return;
    }

    // Verifica que el usuario tenga permisos para calificar.
    if (!has_capability('mod/assign:grade', $context)) {
        return;
    }

    // Agrega el botón en la barra contextual de la actividad.
    $node = $settingsnav->find('modassign', navigation_node::TYPE_CONTAINER);
    if ($node) {
        $url = new moodle_url('/local/greetings/index.php', ['id' => $PAGE->cm->id]);
        $node->add(
            get_string('pluginname', 'local_greetings'),
            $url,
            navigation_node::TYPE_SETTING,
            null,
            'localgreetings'
        );
    }
}*/


/**
 * Devuelve el saludo personalizado según país del usuario.
 *
 * @param stdClass|null $user El objeto de usuario (puede ser null)
 * @return string
 */
function local_greetings_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_greetings');
    }

    $country = $user->country;
    switch ($country) {
        case 'ES' || 'EC':
            $langstr = 'greetinguseres';
            break;
        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greetings', fullname($user));
}




/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
/*
function local_greetings_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_greetings'),
        new moodle_url('/local/greetings/index.php'),
        navigation_node::TYPE_CUSTOM,
    );
}

defined('MOODLE_INTERNAL') || die(); 
function local_greetings_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_greetings');
    }

    $country = $user->country;
    switch ($country) {
        case 'ES':
            $langstr = 'greetinguseres';
            break;
        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greetings', fullname($user));
}
*/
