<?php

require('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
require_sesskey();

header('Content-Type: application/json');

$context = context_course::instance($courseid);
require_capability('moodle/course:view', $context);

// Simulación de feedback generado por IA
$feedback = get_string('nofeedbackyet', 'local_aigrading');
$mensaje = "La retroalimentación que tú me diste fue \"$feedback\", pero no me pareció del todo correcta. Podríamos mejorar en ...";

echo json_encode([
    'success' => true,
    'rubric' => $mensaje,
    'feedbacksummary' => $feedback,
]);
