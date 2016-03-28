Feature: Shorten a link
  In order to more easily share a long link
  As a normal user
  I need to create a short link that points to the long link

  Scenario: Long link is valid
    Given long link I want to shorten is "docs.behat.org/en/v3.0/quick_intro_pt1.html"
      And short domain name to be used for the short link is "bern.ly"
      And long link is a valid URL
      And short domain is a valid domain name
      And long link has not been shortened with the short domain before
      And number of long links already shortened with the short domain is 2
     When I shorten the long link
     Then short link I receive back should be "bern.ly/3"
      And new number of long links already shortened with the short domain is 3
