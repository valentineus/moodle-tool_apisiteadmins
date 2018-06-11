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
 * Registration of the system of events.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

namespace tool_apisiteadmins\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Defines how to work with events.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */
class administrator_deleted extends \core\event\base {
    /**
     * Init method.
     */
    protected function init() {
        $this->data["crud"] = "d";
        $this->data["edulevel"] = self::LEVEL_OTHER;
        $this->context = \context_system::instance();
    }

    /**
     * Return localised event name.
     */
    public static function get_name() {
        return new \lang_string("sitelogs", "moodle");
    }

    /**
     * Returns description of what happened.
     */
    public function get_description() {
        return "The user '$this->relateduserid' was removed from the list of administrators.";
    }
}
