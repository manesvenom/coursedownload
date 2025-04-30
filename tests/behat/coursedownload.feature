@local @local_coursedownload
Feature: Enable or disable course download for a course
  In order to control whether course materials can be downloaded
  As a teacher or student
  I need to be able to enable or disable the course download setting in course settings and see the download link accordingly

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | One      | teacher1@example.com |
      | student1 | Student   | One      | student1@example.com |
    And the following "custom field categories" exist:
      | name                   | component   | area   | itemid |
      | Course Download Settings| core_course | course | 0      |
    And the following "custom fields" exist:
      | name                 | category                | type     | shortname            | configdata                     | description                                                           |
      | Allow course download | Course Download Settings | checkbox | coursedownload_enabled | {"checkbydefault": 0, "required": 0} | If enabled, teachers and students can download course materials as a ZIP archive. |
    And the following "courses" exist:
      | fullname        | shortname | category | idnumber |
      | Test Course     | TC101     | 0        | TC101     |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | TC101  | editingteacher |
      | student1 | TC101  | student        |
      

  Scenario: Teacher enables course download
    Given I log in as "teacher1"
    And I am on "Test Course" course homepage
    And I navigate to "Settings" in current page administration
    And I click on ".icons-collapse-expand[aria-controls='id_category_1container']" "css_element"
    When I set the field "customfield_coursedownload_enabled" to "1"
    And I press "Save and display"
    And I navigate to "Settings" in current page administration
    And I click on ".icons-collapse-expand[aria-controls='id_category_1container']" "css_element"
    Then the field "customfield_coursedownload_enabled" matches value "1"

  Scenario: Student sees and clicks the course download link when enabled
    Given I log in as "student1"
    And I am on "Test Course" course homepage
    Then I should see "Course download"
    When I follow "Course download"
    Then I should be on the "local/coursedownload/download.php" page

  Scenario: Teacher disables course download
    Given I log in as "teacher1"
    And I am on "Test Course" course homepage
    And I navigate to "Settings" in current page administration
    And I click on ".icons-collapse-expand[aria-controls='id_category_1container']" "css_element"
    When I set the field "customfield_coursedownload_enabled" to "0"
    And I press "Save and display"
    And I navigate to "Settings" in current page administration
    And I click on ".icons-collapse-expand[aria-controls='id_category_1container']" "css_element"
    Then the field "customfield_coursedownload_enabled" matches value "0"

  Scenario: Student does not see the course download link when disabled
    Given I log in as "student1"
    And I am on "Test Course" course homepage
    Then I should not see "Course download" 