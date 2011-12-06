Feature: Listing blog posts
  As a Visitor
  I want to browse through blog post list

  Background:
    Given site has users:
      | login | password | email               | url                 | display_name |
      | admin | 121212   | jakub+spam@zalas.pl | http://www.zalas.eu | Jakub Zalas  |
    And site has blog posts:
      | type     | status  | title                                                              | slug                                                               | published_at    | user_login | excerpt | content       |
      | post     | publish | Multistage deployment of Symfony applications with capifony        | multistage-deployment-of-symfony-applications-with-capifony        | 7th May 2011    | admin      | Capifony is a collection of Capistrano deployment recipes. | <a href='/uploads/wp/2011/04/Symfony2-capistrano-multistage-files.png'><img class='size-medium wp-image-709 alignright' title='Capistrano files in Symfony2 project' src='/uploads/wp/2011/04/Symfony2-capistrano-multistage-files-227x400.png' alt='' width='227' height='400' /></a><strong>Capifony</strong> is a collection of <strong>Capistrano</strong> deployment recipes for both <strong>symfony</strong> and <strong>Symfony2</strong> applications. |
      | post     | publish | Setting up a PHP development environment with Nginx on Ubuntu 11.04| setting-up-a-php-development-environment-with-nginx-on-ubuntu-1104 | 5th May 2011    | admin      |  | <img class='alignleft size-full wp-image-749' title='Nginx and PHP' src='/uploads/wp/2011/05/nginx-php.png' alt='' width='349' height='125' />I already described<a title='Setting up a PHP development environment with nginx on Ubuntu 10.04' href='/setting-up-a-php-development-environment-with-nginx-on-ubuntu-1004'> how to prepare a PHP development environment with Nginx on Ubuntu 10.04</a>. |
      | post     | publish | Nginx configuration for Symfony projects                           | nginx-configuration-for-symfony-projects                           | 28th April 2011 | admin      | | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options.<!--more--> <img class='alignright size-full wp-image-736' title='Nginx / Symfony' src='/uploads/wp/2011/04/nginx-symfony.png' alt='' width='350' height='90' />Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time. New variables and directives let me to simplify my configuration for Symfony projects (both 1.x and 2). |
      | revision | inherit | Nginx configuration for Symfony projects revision                  | nginx-configuration-for-symfony-projects-revision                  | 28th April 2011 | admin      | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration. | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time. |
      | post     | draft   | Nginx configuration for Symfony projects draft                     | nginx-configuration-for-symfony-projects-draft                     | 28th April 2011 | admin      | Recent release of Nginx... | todo          |
      | post     | publish | Compiling doctrine in symfony 1.4                                  | compiling-doctrine-in-symfony                                      | 27th April 2011 | admin      |                     | When profiling symfony 1.x applications hydrating Doctrine objects occurs to be one of the most time consuming operations. |
      | page     | publish | About                                                              | about                                                              | 3th May 2010    | admin      |         | About me.     |

  Scenario: Viewing latest blog posts
     When I go to "/blog"
     Then I should see "Multistage deployment of Symfony applications with capifony"
      And I should see "Setting up a PHP development environment with Nginx on Ubuntu 11.04"
      And I should see "Nginx configuration for Symfony projects"
      But I should not see "Nginx configuration for Symfony projects revision"
      And I should not see "Nginx configuration for Symfony projects draft"
      And I should not see "Compiling doctrine in symfony 1.4"
      And I should not see "About"
      And I should see "Capifony is a collection of Capistrano deployment recipes."
      And the response should contain "<img class='alignleft size-full wp-image-749' title='Nginx and PHP' src='/uploads/wp/2011/05/nginx-php.png' alt='' width='349' height='125' />I already described<a title='Setting up a PHP development environment with nginx on Ubuntu 10.04' href='/setting-up-a-php-development-environment-with-nginx-on-ubuntu-1004'> how to prepare a PHP development environment with Nginx on Ubuntu 10.04</a>."
      And I should see "Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options."

  Scenario: Viewing posts are cut to more tag
     When I go to "/blog"
     Then I should see "/nginx-configuration-for-symfony-projects" more link
      And I should see "Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options."
      And I should not see "<img class='alignright size-full wp-image-736' title='Nginx / Symfony' src='/uploads/wp/2011/04/nginx-symfony.png' alt='' width='350' height='90' />Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time. New variables and directives let me to simplify my configuration for Symfony projects (both 1.x and 2)."
