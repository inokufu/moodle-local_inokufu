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
 * Get LO API's Blooms for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_inokufu\external;

defined('MOODLE_INTERNAL') || die();

require_once ($CFG->dirroot . '/local/inokufu/classes/external/common_request.php');

use external_multiple_structure;
use external_single_structure;
use external_value;

class get_bloom extends common_request
{
    /**
     * MOODLE - Call this service from another plugin.
     */
    public static function execute()
    {
        return self::get_and_cache_data('bloom', short_cache: false);
    }

    /**
     * MOODLE - Format of the returned data.
     */
    public static function execute_returns()
    {
        return new external_multiple_structure(
            new external_single_structure(
                [
                    'id_bloom' => new external_value(PARAM_TEXT, 'Bloom ID'),
                    'name' => self::generate_translated_structure(),
                    'description' => self::generate_translated_structure(),
                ]
            )
        );
    }
}
