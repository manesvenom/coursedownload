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
 * Library functions for local_coursedownload
 *
 * @package    local_coursedownload
 * @copyright  2025 manesvenom <manesvenom@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extend the course navigation to add a course download link if enabled.
 *
* @param navigation_node $navigation
 * @param stdClass $course
 * @param context_course $context
 */
function local_coursedownload_extend_navigation_course($navigation, $course, $context) {
    global $DB;
    
    $enabled = $DB->get_field_sql(
        "SELECT d.intvalue 
         FROM {customfield_data} d
         JOIN {customfield_field} f ON f.id = d.fieldid
         JOIN {customfield_category} c ON c.id = f.categoryid
         WHERE f.shortname = ? 
         AND c.component = ? 
         AND c.area = ?
         AND d.instanceid = ?",
        ['coursedownload_enabled', 'core_course', 'course', $course->id]
    );

    if (empty($enabled)) {
        return;
    }

    // Only check for download permission since if they can see the course, they must have view permission
    $hasdownload = has_capability('local/coursedownload:downloadcoursecontent', $context);

    if ($hasdownload) {
        $url = new moodle_url('/local/coursedownload/download.php', ['courseid' => $course->id]);
        $navigation->add(
            get_string('coursedownload', 'local_coursedownload'),
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'coursedownload',
            new pix_icon('i/export', '')
        );
    }
} 