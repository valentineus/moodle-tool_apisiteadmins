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
 * Test 'tool_apisiteadmins' class.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

defined("MOODLE_INTERNAL") || die();

require_once(__DIR__ . "/../lib.php");

/**
 * Test 'tool_apisiteadmins' class.
 *
 * @group       tool_apisiteadmins
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */
class tool_apisiteadmins_api_testcase extends advanced_testcase {
    public function test_adding_and_deleting_administrator() {
        global $CFG;

        $this->resetAfterTest(true);

        $user = $this->getDataGenerator()->create_user();

        /* Adds a user to the list */
        tool_apisiteadmins::add_user($user->id);
        $this->assertArrayHasKey($user->id, get_admins());
        $this->assertCount(2, get_admins());

        /* Re-adds the user to the list */
        tool_apisiteadmins::add_user($user->id);
        $this->assertArrayHasKey($user->id, get_admins());
        $this->assertCount(2, get_admins());

        /* Removes the user from the list */
        tool_apisiteadmins::remove_user($user->id);
        $this->assertArrayNotHasKey($user->id, get_admins());
        $this->assertCount(1, get_admins());

        /* Removes a remote user from the list */
        tool_apisiteadmins::remove_user($user->id);
        $this->assertArrayNotHasKey($user->id, get_admins());
        $this->assertCount(1, get_admins());
    }

    /**
     * @depends test_adding_and_deleting_administrator
     */
    public function test_changing_main_administrator() {
        global $CFG;

        $this->resetAfterTest(true);

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        /* Adds users to the list */
        tool_apisiteadmins::add_user($user1->id);
        tool_apisiteadmins::add_user($user2->id);
        $this->assertArrayHasKey($user1->id, get_admins());
        $this->assertArrayHasKey($user2->id, get_admins());

        /* Sets first user main */
        tool_apisiteadmins::set_main($user1->id);
        $this->assertCount(3, get_admins());
        $this->assertEquals($user1, get_admin());

        /* Sets second user main */
        tool_apisiteadmins::set_main($user2->id);
        $this->assertCount(3, get_admins());
        $this->assertEquals($user2, get_admin());
    }

    /**
     * @depends test_adding_and_deleting_administrator
     */
    public function test_exception_adding_check() {
        global $CFG;

        $this->expectException(moodle_exception::class);
        $this->resetAfterTest(true);

        $userid = mt_rand(99, 999);

        /* Adds a non-existent user */
        tool_apisiteadmins::add_user($userid);
    }

    /**
     * @depends test_adding_and_deleting_administrator
     */
    public function test_exception_removal_check() {
        global $CFG;

        $this->expectException(moodle_exception::class);
        $this->resetAfterTest(true);

        $userid = mt_rand(99, 999);

        /* Removes a non-existent user */
        tool_apisiteadmins::remove_user($userid);
    }
}
