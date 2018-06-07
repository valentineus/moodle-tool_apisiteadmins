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
 * Main functions of the plugin.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

defined("MOODLE_INTERNAL") || die();

/**
 * Functions for working with the list of administrators.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */
class tool_apisiteadmins {
    /**
     * Adds a user to the list of administrators.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     */
    public static function add_user($userid) {
        if (!core_user::is_real_user($userid, true)) {
            print_error("invaliduser", "error", null);
        }

        $userid = (int)$userid;
        $admins = self::get_list();
        $admins[$userid] = $userid;

        self::create_event("administrator_added", $userid);
        return self::save_changes($admins);
    }

    /**
     * Removes a user from the list of administrators.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     */
    public static function remove_user($userid) {
        if (!core_user::is_real_user($userid, true)) {
            print_error("invaliduser", "error", null);
        }

        $userid = (int)$userid;
        $admins = self::get_list();
        unset($admins[$userid]);

        self::create_event("administrator_deleted", $userid);
        return self::save_changes($admins);
    }

    /**
     * Registers the user as the primary administrator.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     */
    public static function set_main($userid) {
        if (!core_user::is_real_user($userid, true)) {
            print_error("invaliduser", "error", null);
        }

        $userid = (int)$userid;
        $admins = self::get_list();
        if (isset($admins[$userid])) {
            unset($admins[$userid]);
            array_unshift($admins, $userid);
        }

        self::create_event("administrator_changed", $userid);
        return self::save_changes($admins);
    }

    /**
     * Creates an entry in the system log.
     *
     * @param   string  $name   Event name
     * @param   number  $userid System user ID
     */
    private static function create_event($name, $userid) {
        $function = "tool_apisiteadmins\\event\\$name";
        $function::create(array("relateduserid" => $userid))->trigger();
    }

    /**
     * Applies the changes on the site.
     *
     * @return  array           List of administrators
     */
    private static function get_list() {
        $config = get_config("core", "siteadmins");

        $result = array();
        foreach (explode(",", $config) as $id) {
            $id = (int)$id;
            if (!empty($id)) {
                $result[$id] = $id;
            }
        }

        return $result;
    }

    /**
     * Applies the changes on the site.
     *
     * @param   array   $admins List of administrators
     */
    private static function save_changes($admins) {
        if (empty($admins)) {
            $admins = self::get_list();
        }

        return set_config("siteadmins", implode(",", $admins));
    }
}
