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
 * Cache settings for the local_inokufu plugin.
 *
 * @package   local_inokufu
 * @copyright 2024, Inokufu
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_inokufu\external;

defined('MOODLE_INTERNAL') || die();
require_once (__DIR__ . '/constants.php');

use cache;

class cache_service
{
    /**
     * Create a cache instance, depending if a short or long cache is needed.
     *
     * @param boolean $short_cache If true, a short cache will be created, else a long one.
     * @return cache Created cache.
     */
    private static function make_cache($short_cache = false)
    {
        $cache_name = $short_cache ? SERVICE_CACHE_SHORT : SERVICE_CACHE_LONG;
        return cache::make(INO_SERVICE_NAME, $cache_name);
    }

    /**
     * Set a value in a cache.
     *
     * @param string $key Key used to store data.
     * @param array $data JSON data to store.
     * @param boolean $short_cache If true, a short cache will be used, else a long one.
     * @return void
     */
    public static function set_cache($key, $data, $short_cache = false)
    {
        $cache = self::make_cache($short_cache);
        $cache->set($key, json_encode($data));
    }

    /**
     * Get a value from a cache.
     *
     * @param string $key Key used to retrieve data.
     * @param boolean $short_cache If true, a short cache will be used, else a long one.
     * @return array JSON data retrieved.
     */
    public static function get_cache($key, $short_cache = false)
    {
        $cache = self::make_cache($short_cache);
        return json_decode($cache->get($key), true);
    }
}