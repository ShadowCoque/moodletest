<?php
define('AJAX_SCRIPT', true);
require_once(__DIR__ . '/../../config.php');

require_login();
$courseid = required_param('courseid', PARAM_INT);
require_sesskey();

$context = context_course::instance($courseid);

// require_capability('moodle/course:viewparticipants', $context); // opcional
global $DB;

// 👇 Primero obtenemos el ID del rol "student"
$studentrole = $DB->get_record('role', ['shortname' => 'student'], '*', IGNORE_MISSING);
if (!$studentrole) {
    echo json_encode(['success' => false, 'message' => 'Student role not found']);
    exit;
}

// 👇 Consulta SQL para usuarios con rol student en el curso
$sql = "SELECT u.id, CONCAT(u.firstname, ' ', u.lastname) AS name
        FROM {user} u
        JOIN {role_assignments} ra ON ra.userid = u.id
        JOIN {context} ctx ON ctx.id = ra.contextid
        WHERE ctx.contextlevel = :contextlevel
          AND ctx.instanceid = :courseid
          AND ra.roleid = :roleid
          AND u.deleted = 0
        ORDER BY name ASC";

$params = [
    'contextlevel' => CONTEXT_COURSE,
    'courseid' => $courseid,
    'roleid' => $studentrole->id
];

$students = $DB->get_records_sql($sql, $params);

$student_list = array_map(function($s) {
    return ['id' => $s->id, 'name' => $s->name];
}, array_values($students));

echo json_encode([
    'success' => true,
    'students' => $student_list
]);
