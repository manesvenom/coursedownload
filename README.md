# Course Download (local_coursedownload)

This file is part of the local_coursedownload plugin for Moodle.

## Description

The Course Download plugin enables teachers to control whether course materials can be downloaded by users. When enabled for a course, teachers and students can download all course resources as a ZIP archive for offline use or archiving. Teachers can toggle this feature in the course settings.

## Features
- Adds a course-level setting to allow or disallow downloading of course materials
- Respects Moodle roles and capabilities (only users with course editing rights can change the setting)
- No new database tables required; uses Moodle's config API
- Language support for English (extendable)

## Installation
1. Copy the plugin folder to `local/coursedownload` in your Moodle directory.
2. Visit the Moodle admin notifications page to complete installation.
3. No additional configuration is required at the site level.

## Usage
- As a teacher or course editor, go to the course settings page.
- Enable or disable the "Allow course download" option.
- When enabled, a download option can be made available to users (future versions will provide UI integration for download links/buttons).

## Privacy
This plugin does not store any personal data and fully relies on Moodle's core APIs for configuration and permissions.

## License

This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

See [LICENSE](http://www.gnu.org/licenses/) for details.

---

*Author:* manesvenom <manesvenom@gmail.com> 