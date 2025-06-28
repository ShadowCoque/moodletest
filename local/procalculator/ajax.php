<?php
// endpoint php que respondera a las peticiones ajax
/** se encargara de
 * validar parametros
 * verificar sesskey y login
 * realizar la operacion
 * retornar json con el resultado
 */

//  Se indica a Moodle que este script es usado para AJAX y no debe renderizar HTML
define('AJAX_SCRIPT', true);

//  Cargamos toda la configuración y entorno de Moodle
require_once(__DIR__ . '/../../config.php');

//  Verificamos que el usuario esté autenticado
require_login();

//  Obtenemos y validamos los parámetros enviados desde el cliente (JS)
$first = required_param('firstNumber', PARAM_INT);
$second = required_param('secondNumber', PARAM_INT);
$op = required_param('operacion', PARAM_ALPHA);
$courseid = required_param('courseid', PARAM_INT);
require_sesskey(); // Verifica el token de seguridad contra ataques CSRF

// Configuramos el contexto del curso y verificamos permisos
$context = context_course::instance($courseid);
//require_capability('moodle/course:view', $context);

// Definimos la cabecera de la respuesta como JSON
header('Content-Type: application/json');

// Lógica para calcular el resultado según la operación
switch ($op) {
    case 'sumsubmit':
        $res = $first + $second;
        break;
    case 'substractsubmit':
        $res = $first - $second;
        break;
    case 'multiplicationsubmit':
        $res = $first * $second;
        break;
    case 'divisionsubmit':
        // Evitamos división por cero
        if ($second == 0) {
            echo json_encode(['success' => false, 'error' => 'División por cero.']);
            exit;
        }
        $res = $first / $second;
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Operación no reconocida.']);
        exit;
}

// Devolvemos la respuesta JSON con el resultado
echo json_encode([
    'success' => true,
    'resultado' => $res
]);
