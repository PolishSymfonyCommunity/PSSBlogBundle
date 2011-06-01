Feature: Viewing tag cloud
  As a Visitor
  I want to use a tag cloud
  So I could easily find topics I am interested in

  Background:
    Given site has users:
      | login | password | email               | url                 | display_name |
      | admin | 121212   | jakub+spam@zalas.pl | http://www.zalas.eu | Jakub Zalas  |
    And site has tags:
      | tag      |
      | symfony  |
      | Symfony2 |
      | php      |
      | nginx    |
      | ubuntu   |
      | doctrine |
      | config   |
    And site has categories:
      | tag      |
      | Default  |
      | symfony  |
    And site has blog posts:
      | type     | status  | title | slug  | published_at    | user_login | excerpt | content  | tags | categories |
      | post     | publish | Multistage deployment of Symfony applications with capifony        | multistage-deployment-of-symfony-applications-with-capifony        | 7th May 2011    | admin      | Capifony is a collection of Capistrano deployment recipes. | <a href='/uploads/wp/2011/04/Symfony2-capistrano-multistage-files.png'><img class='size-medium wp-image-709 alignright' title='Capistrano files in Symfony2 project' src='/uploads/wp/2011/04/Symfony2-capistrano-multistage-files-227x400.png' alt='' width='227' height='400' /></a><strong>Capifony</strong> is a collection of <strong>Capistrano</strong> deployment recipes for both <strong>symfony</strong> and <strong>Symfony2</strong> applications. | symfony,capifony | Default |
      | post     | publish | Setting up a PHP development environment with Nginx on Ubuntu 11.04| setting-up-a-php-development-environment-with-nginx-on-ubuntu-1104 | 5th May 2011    | admin      |  | <img class='alignleft size-full wp-image-749' title='Nginx and PHP' src='/uploads/wp/2011/05/nginx-php.png' alt='' width='349' height='125' />I already described<a title='Setting up a PHP development environment with nginx on Ubuntu 10.04' href='/setting-up-a-php-development-environment-with-nginx-on-ubuntu-1004'> how to prepare a PHP development environment with Nginx on Ubuntu 10.04</a>. | nginx,php,ubuntu | Default |
      | post     | publish | Nginx configuration for Symfony projects                           | nginx-configuration-for-symfony-projects                           | 28th April 2011 | admin      | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. | <img class='alignright size-full wp-image-736' title='Nginx / Symfony' src='/uploads/wp/2011/04/nginx-symfony.png' alt='' width='350' height='90' />Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time. New variables and directives let me to simplify my configuration for Symfony projects (both 1.x and 2). | symfony,nginx | Default |
      | revision | inherit | Nginx configuration for Symfony projects revision                  | nginx-configuration-for-symfony-projects-revision                  | 28th April 2011 | admin      | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration. | Recent release of Nginx 1.0.0 triggered me to refresh my knowledge about its configuration options. There were quite some additions since I looked in the docs for the last time. | symfony,nginx,config | Default |
      | post     | draft   | Nginx configuration for Symfony projects draft                     | nginx-configuration-for-symfony-projects-draft                     | 28th April 2011 | admin      | Recent release of Nginx... | todo          | nginx,symfony | Default |
      | post     | publish | Compiling doctrine in symfony 1.4                                  | compiling-doctrine-in-symfony                                      | 27th April 2011 | admin      | When profiling symfony 1.x applications hydrating Doctrine objects occurs to be one of the most time consuming operations. | <img class='alignleft size-full wp-image-725' title='Doctrine' src='/uploads/wp/2011/04/doctrine.png' alt='' width='50' height='56' />When profiling symfony 1.x applications hydrating Doctrine objects occurs to be one of the most time consuming operations. Recently I experienced something different. Loading ORM classes was one of the most expensive tasks. Usually such operations don't even show up during profiling. | symfony,doctrine | Default |
      | page     | publish | About                                                              | about                                                              | 3th May 2010    | admin      |         | About me.     |         | Default,symfony |

  Scenario: Only active tags are visible
     When I go to /blog
     Then I should see "3 posts tagged with symfony"
      And I should see "2 posts tagged with nginx"
      And I should see "One post tagged with capifony"
      And I should see "One post tagged with php"
      And I should see "One post tagged with ubuntu"
      And I should see "One post tagged with doctrine"
      But I should not see "tagged with Symfony2"
      And I should not see "tagged with config"
      And I should not see "tagged with Default"

