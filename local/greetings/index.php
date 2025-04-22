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
echo $OUTPUT->footer();
