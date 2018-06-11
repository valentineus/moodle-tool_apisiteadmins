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
 * Registers external functions.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    "tool_apisiteadmins_add_to_administrators" => array(
        "classname"     => "tool_apisiteadmins_external",
        "classpath"     => "admin/tool/apisiteadmins/externallib.php",
        "description"   => "Adds a user to the list of administrators.",
        "methodname"    => "add_to_administrators",
        "type"          => "write"
    ),

    "tool_apisiteadmins_remove_from_administrators" => array(
        "classname"     => "tool_apisiteadmins_external",
        "classpath"     => "admin/tool/apisiteadmins/externallib.php",
        "description"   => "Removes a user from the list of administrators.",
        "methodname"    => "remove_from_administrators",
        "type"          => "write"
    ),

    "tool_apisiteadmins_change_main_administrator" => array(
        "classname"     => "tool_apisiteadmins_external",
        "classpath"     => "admin/tool/apisiteadmins/externallib.php",
        "description"   => "Registers the user as the primary administrator.",
        "methodname"    => "change_main_administrator",
        "type"          => "write"
    ),

    "tool_apisiteadmins_get_list_administrators" => array(
        "classname"     => "tool_apisiteadmins_external",
        "classpath"     => "admin/tool/apisiteadmins/externallib.php",
        "description"   => "Gets the list of administrators in the system.",
        "methodname"    => "get_list_administrators",
        "type"          => "read"
    ),

    "tool_apisiteadmins_get_main_administrator" => array(
        "classname"     => "tool_apisiteadmins_external",
        "classpath"     => "admin/tool/apisiteadmins/externallib.php",
        "description"   => "Gets information about the main administrator.",
        "methodname"    => "get_main_administrator",
        "type"          => "read"
    )
);
