Feature: Reading blog posts
  As a Visitor
  I want to read a blog post

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

  Scenario: Viewing published post
     When I visit the list of blog posts page
      And I click the "Multistage deployment with capifony" title on the blog post list
     Then I should see the "Multistage deployment with capifony" blog post

  Scenario: Viewing draft post
     When I visit the "Nginx for Symfony projects draft" blog post page
     Then I should see "Page Not Found"

  Scenario: Viewing article as a blog post
     When I visit the "About" blog post page
     Then I should see "About me."

  Scenario: Viewing revision
     When I visit the "Nginx for Symfony projects revision" blog post page
     Then I should see "Page Not Found"

