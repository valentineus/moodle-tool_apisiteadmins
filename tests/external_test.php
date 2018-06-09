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
 * Test 'tool_apisiteadmins_external' class.
 *
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */

defined("MOODLE_INTERNAL") || die();

global $CFG;

require_once(__DIR__ . "/../externallib.php");

/**
 * Test tool_apisiteadmins_external class.
 *
 * @category    phpunit
 * @group       tool_apisiteadmins
 * @copyright   2018 "Valentin Popov" <info@valentineus.link>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package     tool_apisiteadmins
 */
class tool_apisiteadmins_external_testcase extends advanced_testcase {
    public function test_adding_and_deleting_administrator() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $user = $this->getDataGenerator()->create_user();

        /* Adds a user to the list */
        $result = tool_apisiteadmins_external::add_to_administrators($user->id);
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::add_to_administrators_returns(), $result);
        $this->assertArrayHasKey($user->id, get_admins());
        $this->assertCount(2, get_admins());
        $this->assertTrue($result);

        /* Removes the user from the list */
        $result = tool_apisiteadmins_external::remove_from_administrators($user->id);
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::remove_from_administrators_returns(), $result);
        $this->assertArrayNotHasKey($user->id, get_admins());
        $this->assertCount(1, get_admins());
        $this->assertTrue($result);
    }

    /**
     * @depends test_adding_and_deleting_administrator
     */
    public function test_changing_main_administrator() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        /* Adds users to the list */
        tool_apisiteadmins_external::add_to_administrators($user1->id);
        tool_apisiteadmins_external::add_to_administrators($user2->id);
        $this->assertArrayHasKey($user1->id, get_admins());
        $this->assertArrayHasKey($user2->id, get_admins());
        $this->assertCount(3, get_admins());

        /* Changes the primary administrator */
        $result = tool_apisiteadmins_external::change_main_administrator($user1->id);
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::change_main_administrator_returns(), $result);
        $this->assertEquals($user1, get_admin());
        $this->assertTrue($result);

        /* Changes the primary administrator */
        $result = tool_apisiteadmins_external::change_main_administrator($user2->id);
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::change_main_administrator_returns(), $result);
        $this->assertEquals($user2, get_admin());
        $this->assertTrue($result);
    }

    /**
     * @depends test_adding_and_deleting_administrator
     * @depends test_changing_main_administrator
     */
    public function test_getting_list_administrators() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        /* Adds users to the list */
        tool_apisiteadmins_external::add_to_administrators($user1->id);
        tool_apisiteadmins_external::add_to_administrators($user2->id);
        $this->assertArrayHasKey($user1->id, get_admins());
        $this->assertArrayHasKey($user2->id, get_admins());
        $this->assertCount(3, get_admins());

        /* Gets the list of administrators */
        $result = tool_apisiteadmins_external::get_list_administrators();
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::get_list_administrators_returns(), $result);
        $this->assertArraySubset(array("id" => $user1->id), $result[1]);
        $this->assertArraySubset(array("id" => $user2->id), $result[2]);
        $this->assertCount(3, $result);

        /* Changes the primary administrator */
        tool_apisiteadmins_external::change_main_administrator($user1->id);
        $result = tool_apisiteadmins_external::get_main_administrator();
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::get_main_administrator_returns(), $result);
        $this->assertArraySubset(array("id" => $user1->id), $result[0]);
        $this->assertCount(1, $result);

        /* Changes the primary administrator */
        tool_apisiteadmins_external::change_main_administrator($user2->id);
        $result = tool_apisiteadmins_external::get_main_administrator();
        $result = external_api::clean_returnvalue(tool_apisiteadmins_external::get_main_administrator_returns(), $result);
        $this->assertArraySubset(array("id" => $user2->id), $result[0]);
        $this->assertCount(1, $result);
    }
}
