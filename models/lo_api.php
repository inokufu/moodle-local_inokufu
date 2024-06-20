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
 * LO API models (for PHP/Moodle) for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_inokufu\external;

defined('MOODLE_INTERNAL') || die();

require_once ($CFG->dirroot . '/local/inokufu/classes/external/common_request.php');

use external_multiple_structure;    // For array of structures
use external_single_structure;      // For a single structure
use external_value;                 // For a single value


class lo_api_models
{
    public static function lo_response_structure()
    {
        return new external_single_structure(
            [
                'id' => new external_value(PARAM_TEXT, 'ID'),
                'title' => new external_value(PARAM_TEXT, 'Title'),
                'url' => new external_value(PARAM_URL, 'URL'),
                'score' => new external_value(PARAM_FLOAT, 'Score', VALUE_OPTIONAL),
                'description' => new external_value(PARAM_TEXT, 'Description', VALUE_OPTIONAL),
                'lang' => new external_value(PARAM_TEXT, 'Language', VALUE_OPTIONAL),
                'note' => new external_value(PARAM_FLOAT, 'Note', VALUE_OPTIONAL),
                'provider' => new external_value(PARAM_TEXT, 'Provider'),
                'type' => new external_multiple_structure(
                    new external_value(PARAM_TEXT, 'Type'),
                    'Types',
                    VALUE_OPTIONAL
                ),
                'bloom' => new external_multiple_structure(
                    new external_value(PARAM_TEXT, 'Bloom level'),
                    'Blooms',
                    VALUE_OPTIONAL
                ),
                'picture' => new external_single_structure(
                    [
                        'full_width' => new external_value(PARAM_TEXT, 'Full width picture URL'),
                        'square' => new external_value(PARAM_TEXT, 'Square picture URL')
                    ],
                    'Pictures',
                    VALUE_OPTIONAL
                ),
                'duration' => new external_single_structure(
                    [
                        'index' => new external_value(PARAM_FLOAT, 'Duration index'),
                        'minute' => new external_value(PARAM_FLOAT, 'Duration in minutes'),
                        'value' => new external_value(PARAM_FLOAT, 'Duration value'),
                        'unit' => new external_value(PARAM_TEXT, 'Duration unit')
                    ],
                    'Duration',
                    VALUE_OPTIONAL
                ),
                'address' => new external_single_structure(
                    [
                        'text' => new external_value(PARAM_TEXT, 'Address text'),
                        'geo_coordinates' => new external_single_structure(
                            [
                                'type' => new external_value(PARAM_TEXT, 'Geo coordinates type'),
                                'coordinates' => new external_multiple_structure(
                                    new external_value(PARAM_FLOAT, 'Coordinate value')
                                )
                            ]
                        )
                    ],
                    'Address',
                    VALUE_OPTIONAL
                ),
                'price' => new external_single_structure(
                    [
                        'value' => new external_value(PARAM_FLOAT, 'Price value'),
                        'currency' => new external_value(PARAM_TEXT, 'Currency'),
                        'free' => new external_value(PARAM_BOOL, 'Is it free?'),
                        '@context' => new external_value(PARAM_URL, 'Schema.org context URL'),
                        '@type' => new external_value(PARAM_TEXT, 'Schema.org type')
                    ],
                    'Price',
                    VALUE_OPTIONAL
                ),
                'author' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'name' => new external_value(PARAM_TEXT, 'Author name')
                        ]
                    ),
                    'Author',
                    VALUE_OPTIONAL
                ),
                'publisher' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'name' => new external_value(PARAM_TEXT, 'Publisher name')
                        ]
                    ),
                    'Publisher',
                    VALUE_OPTIONAL
                ),
                'license' => new external_single_structure(
                    [
                        'url' => new external_value(PARAM_URL, 'License URL')
                    ],
                    'License',
                    VALUE_OPTIONAL
                ),
                'date' => new external_single_structure(
                    [
                        'publication' => new external_value(PARAM_TEXT, 'Publication date'),
                        'updated' => new external_value(PARAM_TEXT, 'Last updated date')
                    ],
                    'Date',
                    VALUE_OPTIONAL
                )
            ]
        );
    }
}