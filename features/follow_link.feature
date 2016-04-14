Feature: Follow a short link
  In order to view the material shared via a short link
  As a visitor
  I should be redirected to the long link

  Background:
    Given the system uses "bern.ly" as the domain name for the short link

  Scenario: Successful redirection
    Given I want to follow the short link "bern.ly/1"
    And the short link has been created from the long link "docs.behat.org/en/v3.0/quick_intro_pt1.html"
    When I follow the short link
    Then the system should redirect me to the long link

  Scenario: Short link does not exist
    Given I want to follow the short link "bern.ly/soup"
    But the short link does not exist
    When I follow the short link
    Then the system should tell me that "The short link has not been created yet."
