<?php

/**
 * Place environment initialization scripts here:
 *
 *   $world->initialSum = 231;
 *   $world->calc = function() {
 *       // ...
 *   };
 *
 */


$container = $world->getKernel()->getContainer();
$entityManager = $container->get('doctrine.orm.entity_manager');

$entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\TermRelationship')->execute();
$entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\TermTaxonomy')->execute();
$entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\Post')->execute();
$entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\Term')->execute();
$entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\User')->execute();

$world->users = array();
$world->posts = array();
$world->terms = array();
$world->taxonomies = array('post_tag' => array(), 'category' => array());

