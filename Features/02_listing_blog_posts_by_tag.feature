Feature: Listing blog posts by tag
  As a Visitor
  I want to browse through blog posts tagged with a chosen term
  In order to find blog posts on topic of my interest

  Background:
    Given the following users are blog authors
      | Login | Display name | Password | E-mail              | URL                 |
      | admin | Jakub Zalas  | 121212   | jakub+spam@zalas.pl | http://www.zalas.eu |
      | l3l0  | Leszek       | 131313   | xxx@gmail.com       | http://www.l3l0.eu  |
    Given the following blog posts are written
      | Title                                    | Author | Type     | Status  | Published at    | Excerpt                                                    | Content                                                                                                                                                                                                                                                                                                                                                                                                                                                         | Slug                                                               |
      | Multistage deployment with capifony      | admin  | post     | publish | 7th May 2011    | Capifony is a collection of Capistrano deployment recipes. | <strong>Capifony</strong> is a collection of <strong>Capistrano</strong> deployment recipes for both <strong>symfony</strong> and <strong>Symfony2</strong> applications.                                                                                  | multistage-deployment-of-symfony-applications-with-capifony        |
      | Setting up a PHP development environment | l3l0   | post     | publish | 5th May 2011    |                                                            | I already described<a title="Setting up a PHP development environment with nginx on Ubuntu 10.04" href="/setting-up-a-php-development-environment-with-nginx-on-ubuntu-1004"> how to prepare a PHP development environment with Nginx on Ubuntu 10.04</a>. | setting-up-a-php-development-environment-with-nginx-on-ubuntu-1104 |
      | Nginx configuration for Symfony projects | admin  | post     | publish | 28th April 2011 |                                                            | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options.<!--more--> Content after more tag...                                                                                                                   | nginx-configuration-for-symfony-projects                           |
      | Nginx for Symfony projects revision      | admin  | revision | inherit | 28th April 2011 | Recent release of Nginx 1.0.0 triggered me...              | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time.                                                                          | nginx-configuration-for-symfony-projects-revision                  |
      | Nginx for Symfony projects draft         | admin  | post     | draft   | 28th April 2011 | Recent release of Nginx...                                 | todo                                                                                                                                                                                                                                                       | nginx-configuration-for-symfony-projects-draft                     |
      | Compiling doctrine in symfony 1.4        | admin  | post     | publish | 27th April 2011 |                                                            | When profiling symfony 1.x applications hydrating Doctrine objects occurs to be one of the most time consuming operations.                                                                                                                                 | compiling-doctrine-in-symfony                                      |
      | About                                    | admin  | page     | publish | 3th May 2010    |                                                            | About me.                                                                                                                                                                                                                                                  | about                                                              |
    And the blog posts are tagged with the following terms
      | Title                                    | Tags             |
      | Multistage deployment with capifony      | symfony,capifony |
      | Setting up a PHP development environment | nginx,php,ubuntu |
      | Nginx configuration for Symfony projects | symfony,nginx    |
      | Nginx for Symfony projects revision      | symfony,nginx    |
      | Nginx for Symfony projects draft         | nginx,symfony    |
      | Compiling doctrine in symfony 1.4        | symfony,doctrine |
      | About                                    | symfony          |

  Scenario: Viewing posts tagged with an existing term
     When I visit the list of blog posts tagged with "symfony" page
     Then I should see "Multistage deployment with capifony" title on the blog post list
      And I should not see "Setting up a PHP development environment" title on the blog post list
      And I should see "Nginx configuration for Symfony projects" title on the blog post list
      But I should not see "Nginx for Symfony projects revision" title on the blog post list
      And I should not see "Nginx for Symfony projects draft" title on the blog post list
      And I should see "Compiling doctrine in symfony 1.4" title on the blog post list
      And I should not see "About" title on the blog post list

  Scenario: Viewing posts tagged with a non existing term
     When I visit the list of blog posts tagged with "does-not-exists" page
     Then I should see "Page Not Found"
