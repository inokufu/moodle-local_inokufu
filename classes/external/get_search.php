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
 * Make LO API's Search for the local_inokufu plugin.
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
use external_multiple_structure;
use external_single_structure;
use external_value;
use invalid_parameter_exception;

class get_search extends common_request
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
                        'query' => new external_value(PARAM_TEXT, 'Query'),
                        'lang' => new external_value(PARAM_TEXT, 'Lang', VALUE_OPTIONAL),
                        'model' => new external_value(PARAM_TEXT, 'Model', VALUE_OPTIONAL),
                        'provider' => new external_value(PARAM_TEXT, 'Provider', VALUE_OPTIONAL),
                        'type' => new external_value(PARAM_TEXT, 'Type', VALUE_OPTIONAL),
                        'bloom' => new external_value(PARAM_TEXT, 'Bloom', VALUE_OPTIONAL),
                        'note_min' => new external_value(PARAM_FLOAT, 'Note Min', VALUE_OPTIONAL),
                        'duration_unit' => new external_value(PARAM_TEXT, 'Duration Unit', VALUE_OPTIONAL),
                        'duration_value_min' => new external_value(PARAM_FLOAT, 'Duration Value Min', VALUE_OPTIONAL),
                        'duration_value_max' => new external_value(PARAM_FLOAT, 'Duration Value Max', VALUE_OPTIONAL),
                        'free' => new external_value(PARAM_BOOL, 'Is it free?', VALUE_OPTIONAL),
                        'latitude' => new external_value(PARAM_FLOAT, 'Latitude', VALUE_OPTIONAL),
                        'longitude' => new external_value(PARAM_FLOAT, 'Longitude', VALUE_OPTIONAL),
                        'distance' => new external_value(PARAM_FLOAT, 'Distance', VALUE_OPTIONAL),
                        'limit' => new external_value(PARAM_INT, 'Limit', VALUE_OPTIONAL),
                        'page' => new external_value(PARAM_INT, 'Page', VALUE_OPTIONAL),
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
        // Query
        if ($params['query'] === null || !is_string($params['query']) || strlen($params['query']) < 1) {
            throw new invalid_parameter_exception('Missing or invalid "$query" parameter for LO Search endpoint, must be a non-empty string.');
        }

        // Note (min)
        if ($params['note_min'] !== null && $params['note_min'] > 100) {
            throw new invalid_parameter_exception('Invalid value for "$note_min" for LO Search endpoint, must be smaller than or equal to 100.');
        }
        if ($params['note_min'] !== null && $params['note_min'] < 0) {
            throw new invalid_parameter_exception('Invalid value for "$note_min" for LO Search endpoint, must be bigger than or equal to 0.');
        }

        // Duration value (min)
        if ($params['duration_value_min'] !== null && $params['duration_value_min'] < 0.0) {
            throw new invalid_parameter_exception('Invalid value for "$duration_value_min" for LO Search endpoint, must be bigger than or equal to 0.0.');
        }

        // Duration value (max)
        if ($params['duration_value_max'] !== null && $params['duration_value_max'] < 0.0) {
            throw new invalid_parameter_exception('Invalid value for "$duration_value_max" for LO Search endpoint, must be bigger than or equal to 0.0.');
        }

        // Latitude
        if ($params['latitude'] !== null && $params['latitude'] > 90.0) {
            throw new invalid_parameter_exception('Invalid value for "$latitude" for LO Search endpoint, must be smaller than or equal to 90.0.');
        }
        if ($params['latitude'] !== null && $params['latitude'] < -90.0) {
            throw new invalid_parameter_exception('Invalid value for "$latitude" for LO Search endpoint, must be bigger than or equal to -90.0.');
        }

        // Longitude
        if ($params['longitude'] !== null && $params['longitude'] > 180.0) {
            throw new invalid_parameter_exception('Invalid value for "$longitude" for LO Search endpoint, must be smaller than or equal to 180.0.');
        }
        if ($params['longitude'] !== null && $params['longitude'] < -180.0) {
            throw new invalid_parameter_exception('Invalid value for "$longitude" for LO Search endpoint, must be bigger than or equal to -180.0.');
        }

        // Limit
        if ($params['limit'] !== null && $params['limit'] > 25) {
            throw new invalid_parameter_exception('Invalid value for "$limit" for LO Search endpoint, must be smaller than or equal to 25.');
        }
        if ($params['limit'] !== null && $params['limit'] < 1) {
            throw new invalid_parameter_exception('Invalid value for "$limit" for LO Search endpoint, must be bigger than or equal to 1.');
        }

        // Page
        if ($params['page'] !== null && $params['page'] < 0) {
            throw new invalid_parameter_exception('Invalid value for "$page" for LO Search endpoint, must be bigger than or equal to 0.');
        }

        // Lang
        if ($params['lang'] !== null && !in_array($params['lang'], self::LANG_ENUM)) {
            throw new invalid_parameter_exception('Invalid value for "$lang" for LO Search endpoint, must be in the enum values.');
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
        $data = self::get_and_cache_data('search', $params, short_cache: true);
        $filtered_data = array_map(function ($item) {
            return self::remove_empty_props($item);
        }, $data);

        return $filtered_data;
    }

    /**
     * MOODLE - Format of the returned data.
     */
    public static function execute_returns()
    {
        return new external_multiple_structure(
            lo_api_models::lo_response_structure()
        );
    }
}
