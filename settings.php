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
 * twitter block settings
 *
 * @package    block_twitter
 * @copyright  2016 Andrew Davidson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_twitter/consumerkey', new lang_string('consumerkey', 'block_twitter'),
        new lang_string('consumerkeydesc', 'block_twitter'), null, PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('block_twitter/consumersecret', new lang_string('consumersecret', 'block_twitter'),
        new lang_string('consumersecretdesc', 'block_twitter'), null, PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('block_twitter/accesstoken', new lang_string('accesstoken', 'block_twitter'),
        new lang_string('accesstokendesc', 'block_twitter'), null, PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('block_twitter/accesssecret', new lang_string('accesssecret', 'block_twitter'),
        new lang_string('accesssecretdesc', 'block_twitter'), null, PARAM_ALPHANUMEXT));
}
