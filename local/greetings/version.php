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
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2025 Admin <admin.local@moodle.local>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die(); //se pone esta linea para archivos que no se acceden directamente como lib.php, version.php, pero no es necesario
// en sripts de entrada como view.php e index.php

$plugin->component = 'local_greetings';
$plugin->release = '0.1.0';
$plugin->version = 2025042202;
$plugin->requires = 2022112800;
$plugin->maturity = MATURITY_ALPHA;
