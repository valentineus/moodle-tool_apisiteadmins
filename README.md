# Advanced API administration management

[![GitHub Release](https://img.shields.io/github/release/valentineus/moodle-tool_apisiteadmins.svg)](https://github.com/valentineus/moodle-tool_apisiteadmins/releases)
[![Build Status](https://travis-ci.org/valentineus/moodle-tool_apisiteadmins.svg?branch=master)](https://travis-ci.org/valentineus/moodle-tool_apisiteadmins)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/eea97c9ae1f54cc0ac7cb6f53966b98c)](https://www.codacy.com/app/valentineus/moodle-tool_apisiteadmins)

The plug-in extends and complements the system API for managing administrators.
Main library is well documented and tested.
Can be used by third-party developers for development.

In addition, the plugin adds functions for
[Web services](https://docs.moodle.org/dev/Web_services)
that interact with the list of administrators.
For documentation on Web services, see Moodle:
`https://example.domain/admin/webservice/documentation.php`

## Installation

Get the installation package in any of the available methods:

* [GitHub Releases](https://github.com/valentineus/moodle-tool_apisiteadmins/releases).
* [Compilation from the source code](#build).

In Moodle in the administration panel go to the "Plugins" section and make a
standard installation of the plug-in.

## Testing

* Perform the installation of `PHPUnit` and configure the test environment.
Use the
[official guide](https://docs.moodle.org/dev/PHPUnit#Installation_of_PHPUnit_via_Composer)
for detailed information.

* To run the plugin test, use the following commands:

```bash
# Run all tests
php vendor/bin/phpunit --testdox --group tool_apisiteadmins

# Or running individual tests
php vendor/bin/phpunit --testdox tool_apisiteadmins_api_testcase admin/tool/apisiteadmins/tests/api_test.php
php vendor/bin/phpunit --testdox tool_apisiteadmins_external_testcase admin/tool/apisiteadmins/tests/external_test.php
```

## Build

Self-assembly package is as follows:

* Clone the repository:

```bash
git clone https://github.com/valentineus/moodle-tool_apisiteadmins.git apisiteadmins
```

* Run the build script:

```bash
cd ./apisiteadmins
/bin/sh build.sh
```

## API

### tool_apisiteadmins::add_user( $userid ) ⇒`Boolean`

Adds a user to the list of administrators.

| Param | Type | Description |
| ------- | -------- | -------------- |
| $userid | `Number` | System user ID |

Example:

```php
require_once($CFG->dirroot . "/admin/tool/apisiteadmins/lib.php");

$userid = 2;
tool_apisiteadmins::add_user($userid);
// result: true
```

### tool_apisiteadmins::remove_user( $userid ) ⇒`Boolean`

Removes a user from the list of administrators.

| Param | Type | Description |
| ------- | -------- | -------------- |
| $userid | `Number` | System user ID |

Example:

```php
require_once($CFG->dirroot . "/admin/tool/apisiteadmins/lib.php");

$userid = 2;
tool_apisiteadmins::remove_user($userid);
// result: true
```

### tool_apisiteadmins::set_main( $userid ) ⇒`Boolean`

Registers the user as the primary administrator.

| Param | Type | Description |
| ------- | -------- | -------------- |
| $userid | `Number` | System user ID |

Example:

```php
require_once($CFG->dirroot . "/admin/tool/apisiteadmins/lib.php");

$userid = 2;
tool_apisiteadmins::set_main($userid);
// result: true
```

## License

<img height="256px" alt="GNU Banner" src="https://www.gnu.org/graphics/runfreegnu.png" />

[GNU GPLv3](LICENSE.txt).
Copyright (c)
[Valentin Popov](mailto:info@valentineus.link).
