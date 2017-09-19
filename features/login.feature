Feature: Login/logout

  In order to access the application
  As a user
  I can log in and out

  Background:
    Given the following users:
      | uuid                                 | username     | firstname   | lastname  | email           | password  | roles      |
      | bf1b0b9a-9d44-11e7-8099-0242ac140002 | max.muster   | Maximilian  | Muster    | muster@host.at  | nT.nB>i6Q | ROLE_ADMIN |

#  Scenario: Unauthenticated users can log in
#    Given I am on "/login"
#    When I fill in "_username" with "maximilian.muster"
#    When I fill in "_password" with "nT.nB>i6Q"
#    When I press "login.login"
#    Then print last response
#    Then the response status code should be 200
#    And I should see "Selfhosted Mailing Software"
#    And I should see "Maximilian Muster"

  Scenario: An error is shown when entering an invalid user name
    Given I am on "/login"
    When I fill in "_username" with "foobar"
    And I fill in "_password" with "nT.nB>i6Q"
    And I press "login.login"
    Then the response status code should be 200
    And the response should contain "Invalid credentials."

  Scenario: An error is shown when entering the wrong password
    Given I am on "/login"
    When I fill in "_username" with "muster@host.at"
    And I fill in "_password" with "foobar"
    And I press "login.login"
    Then the response status code should be 200
    And the response should contain "Invalid credentials."

  Scenario: A logged in user can logout
    Given I am on "/login"
    And I fill in "_username" with "max.muster"
    And I fill in "_password" with "nT.nB>i6Q"
    And I press "login.login"
    When I go to "/logout"
    Then I should be on "/login"
    And the response status code should be 200
    And the response should not contain "Du bist eingeloggt"
