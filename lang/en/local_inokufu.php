<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language configuration for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once (__DIR__ . '/../../constants.php');

$string[SERVICES_PLUGIN_NAME] = 'Inokufu Services';

$string[LO_HOST_NAME] = 'LO API Host';
$string[LO_HOST_HELPER] = 'If empty, a default host name will be used. Warning: The host name must ends with a "/"!';

$string[LO_APIKEY_TITLE] = 'LO API key';
$string[LO_APIKEY_HELPER] = 'Get your own <a href="https://gateway.inokufu.com/">LO API Key here</a>.';
