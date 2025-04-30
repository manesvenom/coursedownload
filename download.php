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

require_once(__DIR__ . '/../../config.php');

$courseid = required_param('courseid', PARAM_INT);
require_login($courseid);

$context = context_course::instance($courseid);
require_capability('local/coursedownload:downloadcoursecontent', $context);

// Check if course download is enabled for this course
$enabled = $DB->get_field_sql(
    "SELECT d.value 
     FROM {customfield_data} d
     JOIN {customfield_field} f ON f.id = d.fieldid
     WHERE f.shortname = ? AND d.instanceid = ?",
    ['coursedownload_enabled', $courseid]
);

if (empty($enabled)) {
    throw new moodle_exception('downloadnotallowed', 'local_coursedownload');
}

// TODO: Implement the actual download functionality
// For now, just show a message
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/coursedownload/download.php', ['courseid' => $courseid]));
$PAGE->set_title(get_string('coursedownload', 'local_coursedownload'));
$PAGE->set_heading(get_string('coursedownload', 'local_coursedownload'));

echo $OUTPUT->header();
echo $OUTPUT->notification(get_string('coursedownload', 'local_coursedownload'), 'info');
echo $OUTPUT->footer(); 