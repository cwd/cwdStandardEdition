Feature: User CRUD

  Background:
    Given the following users:
      | uuid                                 | username     | firstname   | lastname  | email           | password  | roles      |
      | bf1b0b9a-9d44-11e7-8099-0242ac140002 | max.muster   | Maximilian  | Muster    | muster@host.at  | nT.nB>i6Q | ROLE_ADMIN |
      | c051e0d4-9d44-11e7-8099-0242ac140002 | erika.muster | Erika       | Muster    | erika@muster.at | nT.nB>i6Q | ROLE_USER  |

  Scenario: See a list
    Given I am authenticated as User "max.muster"
    And I am on "/user/list"
    Then the response status code should be 200
    And I should see "site.title"
    And I should see "Maximilian Muster"
    And the menu item "user.menu_title" is active
    And I should see "user.create"

  Scenario: See a create form
    Given I am authenticated as User "max.muster"
    And I am on "/user/list"
    Then the response status code should be 200
    And I should see "user.create"
    When I follow "user.create"
    Then the response status code should be 200
    And I should be on "/user/create"
    And I should see "user.title" in the "h3" element

  Scenario: See a edit form
    Given I am authenticated as User "max.muster"
    And I am on "/user/edit/bf1b0b9a-9d44-11e7-8099-0242ac140002"
    Then the response status code should be 200
    And I should see "user.title" in the "h3" element
    And the "user_firstname" field should contain "Maximilian"

  Scenario: Edit form has constraints
    Given I am authenticated as User "max.muster"
    And I am on "/user/edit/bf1b0b9a-9d44-11e7-8099-0242ac140002"
    Then the response status code should be 200
    And I should see "user.title" in the "h3" element
    And the "user_firstname" field should contain "Maximilian"
    When I fill in "user_firstname" with ""
    And I press "generic.save"
    Then the response status code should be 200
    And I should see "Dieser Wert sollte nicht leer sein."

  Scenario: See grid list
    Given I am authenticated as User "max.muster"
    And I am on "/user/list"
    Then the response status code should be 200

  Scenario: Can't access users
    Given I am authenticated as User "erika.muster"
    And I am on "/user/list"
    Then the response status code should be 403

  Scenario: Can't create users
    Given I am authenticated as User "erika.muster"
    And I am on "/user/create"
    Then the response status code should be 403

  Scenario: Can't edit users
    Given I am authenticated as User "erika.muster"
    And I am on "/user/edit/bf1b0b9a-9d44-11e7-8099-0242ac140002"
    Then the response status code should be 403



