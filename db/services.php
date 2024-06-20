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
 * Service settings for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once (__DIR__ . '/../constants.php');

// Define the service's functions
$functions = [
    INO_SERVICE_NAME . '_get_host' => [
        'classname' => INO_SERVICE_NAME . '\external\get_host',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get current API host for LO API calls.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_bloom' => [
        'classname' => INO_SERVICE_NAME . '\external\get_bloom',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get blooms from the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_lang' => [
        'classname' => INO_SERVICE_NAME . '\external\get_lang',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get languages from the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_model' => [
        'classname' => INO_SERVICE_NAME . '\external\get_model',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get models from the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_provider' => [
        'classname' => INO_SERVICE_NAME . '\external\get_provider',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get providers from the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_type' => [
        'classname' => INO_SERVICE_NAME . '\external\get_type',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get types from the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_search' => [
        'classname' => INO_SERVICE_NAME . '\external\get_search',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Search for LOs using the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
    INO_SERVICE_NAME . '_get_lo' => [
        'classname' => INO_SERVICE_NAME . '\external\get_lo',
        'methodname' => 'execute',
        'classpath' => '',
        'description' => 'Get LO by ID using the LO API.',
        'type' => 'read',
        'ajax' => true
    ],
];

// Register the functions in the service
$services = [
    get_string(SERVICES_PLUGIN_NAME, INO_SERVICE_NAME) => [
        'functions' => [
            INO_SERVICE_NAME . '_get_host',
            INO_SERVICE_NAME . '_get_bloom',
            INO_SERVICE_NAME . '_get_lang',
            INO_SERVICE_NAME . '_get_model',
            INO_SERVICE_NAME . '_get_provider',
            INO_SERVICE_NAME . '_get_type',
            INO_SERVICE_NAME . '_get_search',
            INO_SERVICE_NAME . '_get_lo',
        ],
        'restrictedusers' => 0,
        'enabled' => 1,
    ]
];
