<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Main file to view greetings
 *
 * @package     local_greetings
 * @copyright   2023 Joel C <joel.coque@epn.edu.ec>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

require_once($CFG->dirroot. '/local/greetings/lib.php');

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_greetings'));
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));

/*
// DEFINICION DE FORM
// Instantiate the myform form from within the plugin.
// $mform = new \local_greetings\form\myform();
*/


$messageform = new \local_greetings\form\message_form();
if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages', $record);
    }
}

echo $OUTPUT->header();
if (isloggedin()) {
    //$usergreeting = 'Greetings, ' . fullname($USER);
    //$usergreeting = get_string('greetingloggedinuser', 'local_greetings', fullname($USER));
    $usergreeting = local_greetings_get_greeting($USER);
} else {
    //$usergreeting = 'Greetings, user';
    $usergreeting = get_string('greetinguser', 'local_greetings');
}

$templatedata = ['usergreeting' => $usergreeting];
// La forma en que se escribe el primer argumento en render_from_template() no es una ruta de archivo, es el "nombre del componente + plantilla"
echo $OUTPUT->render_from_template('local_greetings/greeting_message', $templatedata);
$now = time();
echo userdate($now);
/*
// Form processing and displaying is done here.
if($mform->is_cancelled()) {
    // If there is a cancel element on the form, and it was pressed,
    // then the `is_cancelled()` function will return true.
    // You can handle the cancel operation here.
} else if ($fromform = $mform->get_data()) {
    // When the form is submitted, and the data is successfully validated,
    // the `get_data()` function will return the data posted in the form.
} else {
    // This branch is executed if the form is submitted but the data doesn't
    // validate and the form should be redisplayed or on the first display of the form.
    // Set default data (if any).
    $mform->set_data($toform);
   
    // Display the form.
    $mform->display();
}
*/

$messageform->display();
// $messages = $DB->get_records('local_greetings_messages');
$userfields = \core_user\fields::for_name()->with_identity($context);
$userfieldssql = $userfields->get_sql('u');

$sql = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
          FROM {local_greetings_messages} m
     LEFT JOIN {user} u ON u.id = m.userid
      ORDER BY timecreated DESC";

$messages = $DB->get_records_sql($sql);


/*foreach ($messages as $m) {
    echo '<p>' . $m->message . ', ' . $m->timecreated . '</p>';
}
*/
$templatedata = ['messages' => array_values($messages)];
echo $OUTPUT->render_from_template('local_greetings/messages', $templatedata); // $OUTPUT es un objeto global que sirve para renderizar templates
/*
if ($data = $messageform->get_data()) { // $data = $messageform->get_data() recupera los datos del formulario si ha sido enviado por el usuario
    //var_dump($data); // es una forma práctica de verificar qué datos ha enviado el formulario
    $message = required_param('message', PARAM_TEXT);
    echo $OUTPUT->heading($message, 3);
}
*/

echo $OUTPUT->footer();
