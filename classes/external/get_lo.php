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
 * Get LO from LO API by ID for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_inokufu\external;

defined('MOODLE_INTERNAL') || die();

require_once ($CFG->dirroot . '/local/inokufu/classes/external/common_request.php');
require_once ($CFG->dirroot . '/local/inokufu/models/lo_api.php');

use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;

class get_lo extends common_request
{
    /**
     * MOODLE - Define checks on the parameters of this service.
     * Overrides the default in 'common_request'.
     */
    public static function execute_parameters()
    {
        return new external_function_parameters(
            [
                'params' => new external_single_structure(
                    [
                        'id' => new external_value(PARAM_TEXT, 'ID'),
                    ]
                )
            ]
        );
    }

    /**
     * Additional checks on the service parameters.
     *
     * @param array $params Parameters as associative array.
     * @return array Same params as the input ones.
     */
    private static function check_parameters($params)
    {
        // ID
        if ($params['id'] === null || !is_string($params['id']) || strlen($params['id']) < 1) {
            throw new invalid_parameter_exception('Missing or invalid "$id" parameter for LO GetById endpoint, must be a non-empty string.');
        }

        return $params;
    }

    /**
     * MOODLE - Call this service from another plugin.
     */
    public static function execute($params)
    {
        // Filter the parameters
        $params = self::remove_empty_props($params);
        // Validate the parameters
        $params = self::validate_parameters(
            self::execute_parameters(),
            ['params' => $params]
        );
        // Check for errors
        $params = self::check_parameters($params['params']);

        // Get data
        $data = self::get_and_cache_data('lo/' . $params['id'], short_cache: true);

        return self::remove_empty_props($data);
    }

    /**
     * MOODLE - Format of the returned data.
     */
    public static function execute_returns()
    {
        return lo_api_models::lo_response_structure();
    }
}
