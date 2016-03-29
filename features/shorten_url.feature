Feature: Shorten a link
  In order to more easily share a long link and track the link's analytics
  As a normal user
  I need to create a short link that points to the long link

  Scenario: Long link is valid
    Given the long link I want to shorten is "docs.behat.org/en/v3.0/quick_intro_pt1.html"
      And the short domain name to be used for the short link is "bern.ly"
      And the long link has not been shortened with the short domain before
      And the initial number of long links already shortened with the short domain is 2
     When I shorten the long link
     Then the short link I receive back should be "bern.ly/3"
      And the final number of long links already shortened with the short domain is 3

  Scenario: Long link is invalid
    Given the long link I want to shorten is "d%ocs.behat.org/en/v3.0/quick_intro_pt1.html"
     When I shorten the long link
     Then I should receive back the message that "The link you provided is not a valid URL."