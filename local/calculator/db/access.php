<?php
defined('MOODLE_INTERNAL') || die();
//capacidades o permisos que usa el plugin
$capabilities = [
    'local/calculator:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ]
    ],
];
