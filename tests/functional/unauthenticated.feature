Feature: unauthenticated
  In order to maintain security
  As a casual browser
  I must be redirected to login before any modifications

  Scenario Outline: redirect not logged in
    Given I am not logged in
    When I try to view <page>
    Then I should be redirected to "login"
    Examples:
      | page |
      | "/en/admin/post/" |
      | "/en/admin/post/1/" |
      | "/en/admin/post/1/edit/" |

  Scenario Outline: user does not have access
    Given I am logged in as user
    When I try to view <page>
    Then I should receive error <error>
    Examples:
      | page | error |
      | "/en/admin/post/" | "Access Denied" |
      | "/en/admin/post/1/" | "Access Denied" |
      | "/en/admin/post/1/edit/" | "Access Denied" |
      | "/en/admin/" | "No route found" |
      | "/en/admin/post/1/delete" | "No route found" |
