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
 * Common class used by the local_inokufu plugin's endpoints.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_inokufu\external;

defined('MOODLE_INTERNAL') || die();
require_once (__DIR__ . '/../../constants.php');

require_once ($CFG->libdir . '/externallib.php');

require_once ($CFG->dirroot . '/local/inokufu/cache.php');
require_once ($CFG->dirroot . '/local/inokufu/vendor/autoload.php');

use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class common_request extends external_api
{
    protected const LANG_ENUM = ['fr', 'en'];
    private const DEFAULT_LO_HOST = 'https://api.gateway.inokufu.com/learningobject/v3/';
    private $default_lang;
    private $used_lang;

    /**
     * Common class used to make the LO API calls for Moodle.
     */
    public function __construct()
    {
        global $USER;

        // Pick default lang
        $this->default_lang = self::LANG_ENUM[0];

        // Store user language as the default one
        $this->used_lang = $USER->lang;
        if (!in_array($this->used_lang, self::LANG_ENUM, true)) {
            // Fallback in case user language is not supported
            $this->used_lang = $this->default_lang;
        }
    }

    /**
     * Get LO API host used for all API calls.
     * If not provided in the plugin settings, a default one will be used.
     *
     * @return string LO API host.
     */
    protected static function get_api_host()
    {
        $hostname = get_config(INO_SERVICE_NAME, LO_HOST);
        return empty($hostname) ? self::DEFAULT_LO_HOST : $hostname;
    }

    /**
     * Remove falsy elements in an item (array or object).
     * Returns the cleaned item as an associative array.
     *
     * @param mixed $item Item to clean.
     * @return array Cleaned item.
     */
    protected static function remove_empty_props($item)
    {
        // Convert to associative array if needed.
        if (is_object($item)) {
            $item = get_object_vars($item);
        }
        // Remove falsy values
        return array_filter($item, function ($value) {
            return !empty($value);
        });
    }

    /**
     * Format query params from an associative array to an HTTP string.
     *
     * @param array $params Query params as associative array.
     * @return string Query params as HTTP string.
     */
    private static function format_query_params($params)
    {
        // Filter out null, empty string, and false values
        $params = $params ?? [];
        $filtered_params = self::remove_empty_props($params);

        // Build query string
        return http_build_query($filtered_params, '', '&');
    }

    /**
     * HTTP GET function for Inokufu's LO API.
     *
     * @param string $endpoint_name Name of the endpoint.
     * @param array $params Query params as associative array.
     * @return array Data to return.
     */
    protected static function inokufu_get($endpoint_name, $params = null)
    {
        // Request config
        $client = new Client();
        $formatted_params = self::format_query_params($params);
        $url = self::get_api_host() . $endpoint_name;
        if (!empty($formatted_params)) {
            $url .= '?' . $formatted_params;
        }

        try {
            // GET request
            $response = $client->request(
                'GET',
                $url,
                [
                    'headers' => [
                        'x-api-key' => get_config(INO_SERVICE_NAME, LO_APIKEY),
                    ]
                ]
            );

            // Decode JSON if HTTP 200
            $status_code = $response->getStatusCode();
            if ($status_code >= 200 || $status_code <= 299) {
                $data = json_decode($response->getBody(), true);
                return $data;
            } else {
                throw new Exception("HTTP Error {$status_code}, can't decode data", $status_code);
            }

        } catch (RequestException $e) {
            // Else, throw an exception with HTTP error code
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = $response->getBody()->getContents();
                $status_code = $response->getStatusCode();
                throw new Exception("HTTP Error {$status_code}: {$body}", $status_code);
            } else {
                throw new Exception('HTTP Error 500: ' . $e->getMessage(), 500);
            }
        } catch (Exception $e) {
            // General error
            throw new Exception('Error during GET request: ' . $e->getMessage());
        }
    }

    /**
     * Wrapper for the HTTP GET that also cache the retrieved data.
     * The data is retrieved from the cache if found there, else from the LO API.
     *
     * @param string $endpoint_name Name of the endpoint.
     * @param array $params Query params as associative array.
     * @param boolean $short_cache If true, use the short cache to store data, else the long one.
     * @return array Data retrieved from the API of the cache.
     */
    protected static function get_and_cache_data($endpoint_name, $params = null, $short_cache = false)
    {
        $use_cache = true;
        $cached_key = $endpoint_name;

        // If params, make custom key
        if ($params) {
            $cached_key = implode('_', $params ?? []);
        }
        // Key is too long for an associative array, disable cache
        if (strlen($cached_key) > 255) {
            $use_cache = false;
        }
        // Sanitize key (remove special characters)
        $cached_key = preg_replace('/[^a-zA-Z0-9]/', '_', $cached_key);

        // Get cached data, if possible
        if ($cached_data = cache_service::get_cache($cached_key, $short_cache)) {
            return $cached_data;
        }

        // Else, call endpoint and cache data
        $result = self::inokufu_get($endpoint_name, $params);
        if ($use_cache) {
            cache_service::set_cache($cached_key, $result, $short_cache);
        }
        return $result;
    }

    /**
     * Generate a structure for a translated field from the LO API, 
     * based on a list of supported languages.
     *
     * @return external_single_structure Generated structure.
     */
    protected static function generate_translated_structure()
    {
        $enum_structures = [];
        foreach (self::LANG_ENUM as $value) {
            // Create a structure for each enum value
            $enum_structures[$value] = new external_value(PARAM_TEXT, ucfirst($value));
        }
        return new external_single_structure($enum_structures);
    }

    /**
     * MOODLE - Define checks on the parameters of this service.
     * Default: Function without parameters.
     */
    public static function execute_parameters()
    {
        return new external_function_parameters([]);
    }
}
