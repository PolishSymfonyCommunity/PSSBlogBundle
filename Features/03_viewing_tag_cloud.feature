Feature: Viewing tag cloud
  As a Visitor
  I want to use a tag cloud
  So I could easily find topics I am interested in

  Scenario: Only active tags are visible
    Given there are "5" blog posts tagged with "symfony"
      And there are "3" blog posts tagged with "Symfony2"
      And there are "0" blog posts tagged with "nginx"
     When I visit the list of blog posts page
     Then I should see a tag cloud
      And I should see on the tag cloud that there are "5" blog posts tagged with "symfony"
      And I should see on the tag cloud that there are "3" blog posts tagged with "Symfony2"
      But I should see on the tag cloud that there is no blog posts tagged with "nginx"

  Scenario: Categories are not present on the tag cloud
    Given there are "5" blog posts tagged with "symfony"
      And there are "3" blog posts tagged with "Symfony2"
      And there are "0" blog posts tagged with "nginx"
      And there are "6" blog posts in the "Default" category
      And there are "3" blog posts in the "symfony" category
     When I visit the list of blog posts page
     Then I should see a tag cloud
      And I should see on the tag cloud that there are "5" blog posts tagged with "symfony"
      But I should see on the tag cloud that there is no blog posts tagged with "Default"

