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
 * Plugin settings for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once (__DIR__ . '/constants.php');

// Ensure the configurations for this site are set
if ($hassiteconfig) {

    // Create the new settings page
    $settings = new admin_settingpage(INO_SERVICE_NAME, get_string(SERVICES_PLUGIN_NAME, INO_SERVICE_NAME));

    // Add config for the LO API host name
    $settings->add(
        new admin_setting_configtext(
            INO_SERVICE_NAME . '/' . LO_HOST,
            get_string(LO_HOST_NAME, INO_SERVICE_NAME),
            get_string(LO_HOST_HELPER, INO_SERVICE_NAME),
            '',
            PARAM_URL
        )
    );

    // Add config for the LO API key
    $settings->add(
        new admin_setting_configpasswordunmask(
            INO_SERVICE_NAME . '/' . LO_APIKEY,
            get_string(LO_APIKEY_TITLE, INO_SERVICE_NAME),
            get_string(LO_APIKEY_HELPER, INO_SERVICE_NAME),
            '',
            PARAM_RAW_TRIMMED
        )
    );

    // Append configs to the setting page
    $ADMIN->add('localplugins', $settings);
}