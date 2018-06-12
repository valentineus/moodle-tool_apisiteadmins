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
 * External API.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . "/lib.php");

require_once($CFG->dirroot . "/lib/external/externallib.php");
require_once($CFG->dirroot . "/user/externallib.php");
require_once($CFG->dirroot . "/user/lib.php");

/**
 * External functions.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */
class tool_apisiteadmins_external extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return  external_function_parameters
     * @since   Moodle 2.2
     */
    public static function add_to_administrators_parameters() {
        return new external_function_parameters(
            array(
                "userid" => new external_value(PARAM_INT, "ID of the user")
            )
        );
    }

    /**
     * Adds a user to the list of administrators.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     * @since   Moodle 2.2
     * @throws  moodle_exception
     */
    public static function add_to_administrators($userid) {
        $parameters = self::validate_parameters(self::add_to_administrators_parameters(), array("userid" => $userid));

        $context = context_system::instance();
        self::validate_context($context);

        return tool_apisiteadmins::add_user($parameters["userid"]);
    }

    /**
     * Returns description of method result value.
     *
     * @return  external_description
     * @since   Moodle 2.2
     */
    public static function add_to_administrators_returns() {
        return new external_value(PARAM_BOOL, "Result of execution");
    }

    /**
     * Returns description of method parameters.
     *
     * @return  external_function_parameters
     * @since   Moodle 2.2
     */
    public static function remove_from_administrators_parameters() {
        return new external_function_parameters(
            array(
                "userid" => new external_value(PARAM_INT, "ID of the user")
            )
        );
    }

    /**
     * Removes a user from the list of administrators.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     * @since   Moodle 2.2
     * @throws  moodle_exception
     */
    public static function remove_from_administrators($userid) {
        $parameters = self::validate_parameters(self::remove_from_administrators_parameters(), array("userid" => $userid));

        $context = context_system::instance();
        self::validate_context($context);

        return tool_apisiteadmins::remove_user($parameters["userid"]);
    }

    /**
     * Returns description of method result value.
     *
     * @return  external_description
     * @since   Moodle 2.2
     */
    public static function remove_from_administrators_returns() {
        return new external_value(PARAM_BOOL, "Result of execution");
    }

    /**
     * Returns description of method parameters.
     *
     * @return  external_function_parameters
     * @since   Moodle 2.2
     */
    public static function change_main_administrator_parameters() {
        return new external_function_parameters(
            array(
                "userid" => new external_value(PARAM_INT, "ID of the user")
            )
        );
    }

    /**
     * Registers the user as the primary administrator.
     *
     * @param   number  $userid System user ID
     * @return  boolean         Result of execution
     * @since   Moodle 2.2
     * @throws  moodle_exception
     */
    public static function change_main_administrator($userid) {
        $parameters = self::validate_parameters(self::change_main_administrator_parameters(), array("userid" => $userid));

        $context = context_system::instance();
        self::validate_context($context);

        return tool_apisiteadmins::set_main($parameters["userid"]);
    }

    /**
     * Returns description of method result value.
     *
     * @return  external_description
     * @since   Moodle 2.2
     */
    public static function change_main_administrator_returns() {
        return new external_value(PARAM_BOOL, "Result of execution");
    }

    /**
     * Returns description of method parameters.
     *
     * @return  external_function_parameters
     * @since   Moodle 2.2
     */
    public static function get_main_administrator_parameters() {
        return new external_function_parameters(array());
    }

    /**
     * Gets information about the main administrator.
     *
     * @return  array           An array of arrays containg user profiles
     * @since   Moodle 2.2
     */
    public static function get_main_administrator() {
        $context = context_system::instance();
        self::validate_context($context);

        $result = array();
        $result[] = user_get_user_details(get_admin());

        return $result;
    }

    /**
     * Returns description of method result value.
     *
     * @return  external_description
     * @since   Moodle 2.2
     */
    public static function get_main_administrator_returns() {
        return new external_multiple_structure(core_user_external::user_description());
    }

    /**
     * Returns description of method parameters.
     *
     * @return  external_function_parameters
     * @since   Moodle 2.2
     */
    public static function get_list_administrators_parameters() {
        return new external_function_parameters(array());
    }

    /**
     * Gets the list of administrators in the system.
     *
     * @return  array           An array of arrays containg user profiles
     * @since   Moodle 2.2
     */
    public static function get_list_administrators() {
        $context = context_system::instance();
        self::validate_context($context);

        $result = array();
        foreach (get_admins() as $user) {
            $result[] = user_get_user_details($user);
        }

        return $result;
    }

    /**
     * Returns description of method result value.
     *
     * @return  external_description
     * @since   Moodle 2.2
     */
    public static function get_list_administrators_returns() {
        return new external_multiple_structure(core_user_external::user_description());
    }
}
