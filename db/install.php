<?php

// This file is part of the local_coursedownload plugin for Moodle.
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
 * Install script for local_coursedownload
 *
 * @package    local_coursedownload
 * @copyright  2025 manesvenom <manesvenom@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_local_coursedownload_install() {
    global $DB;

    // Get the handler for course custom fields.
    $handler = \core_course\customfield\course_handler::create();

    // Check if our specific category exists
    $category = $DB->get_record('customfield_category', [
        'component' => 'core_course',
        'area' => 'course',
        'name' => 'Course Download Settings',
        'contextid' => context_system::instance()->id
    ]);

    if (!$category) {
        // Create a new category specifically for course download settings
        $category = new stdClass();
        $category->name = 'Course Download Settings';
        $category->component = 'core_course';
        $category->area = 'course';
        $category->contextid = context_system::instance()->id;
        // Get the maximum sort order and add 1
        $maxsortorder = $DB->get_field_sql('SELECT MAX(sortorder) FROM {customfield_category} WHERE area = ? AND component = ?', 
            ['course', 'core_course']);
        $category->sortorder = $maxsortorder ? $maxsortorder + 1 : 1;
        $category->timecreated = time();
        $category->timemodified = time();
        $category->id = $DB->insert_record('customfield_category', $category);
    }

    // Check if the field already exists.
    $field = $DB->get_record('customfield_field', [
        'shortname' => 'coursedownload_enabled',
        'categoryid' => $category->id
    ]);

    if (!$field) {
        // Create the custom field.
        $field = new stdClass();
        $field->categoryid = $category->id;
        $field->type = 'checkbox';
        $field->name = 'Allow course download';
        $field->shortname = 'coursedownload_enabled';
        $field->description = 'If enabled, teachers and students can download course materials as a ZIP archive.';
        $field->descriptionformat = FORMAT_HTML;
        $field->sortorder = 1;
        $field->timecreated = time();
        $field->timemodified = time();
        $field->configdata = serialize([
            'checkbydefault' => 0,
            'required' => 0,
        ]);
        $DB->insert_record('customfield_field', $field);
    }
} 