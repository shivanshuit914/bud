Feature: Api consumption
  Consumes external API in order to download information from 3rd party

  Scenario: Provides token for successful authentication
    Given There is a third party which provides information to authenticated client
    When I authenticate client
    Then I should receive token


  Scenario: Provides data for successfully authenticated client
    Given Successful authenticated client
    When I try to retrieve information
    Then I should receive details