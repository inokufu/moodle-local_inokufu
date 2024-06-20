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

$string[LO_HOST_NAME] = 'Nom d\'hôte pour l\'API LO';
$string[LO_HOST_HELPER] = 'Si laissé vide, un nom d\'hôte par défaut sera utilisé. Attention : Le nom d\'hôte doit terminer par un "/" !';

$string[LO_APIKEY_TITLE] = 'Clé pour l\'API LO';
$string[LO_APIKEY_HELPER] = 'Obtenez votre <a href="https://gateway.inokufu.com/">clé API LO ici</a>.';
