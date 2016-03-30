Feature: Shorten a link
  In order to more easily share a long link and track the link's analytics
  As a normal user
  I need to create a short link that points to the long link

  When the user requests a link to be shortened, the system uses either a default domain name for the short link, or a domain name provided by the user. The path of the short link is the number of shortened links converted to a number in base 62.

  Background:
    Given the system uses "bern.ly" as the short domain name

  Scenario Outline: Long link has not been shortened before
    Given I want to shorten the long link "docs.behat.org/en/v3.0/quick_intro_pt1.html"
      And the number of long links already shortened with the short domain is <initial link count>
     When I shorten the long link
     Then the system should give the short link "bern.ly/<path>" to me
      And the final number of long links shortened with the short domain is <final link count>
      And the short link should point to the long link

      Examples:
        | initial link count | path | final link count |
        | 0                  | 1    | 1                |
        | 1                  | 2    | 2                |
        | 9                  | a    | 10               |
        | 10                 | b    | 11               |
        | 35                 | A    | 36               |
        | 36                 | B    | 37               |
        | 61                 | 10   | 62               |
        | 62                 | 11   | 63               |
        | 28485              | 7ps  | 28486            |

  Scenario: Long link is invalid
    Given I want to shorten the long link "d%ocs.behat.org/en/v3.0/quick_intro_pt1.html"
     When I shorten the long link
     Then the system should tell me that "The link you provided is not a valid URL."