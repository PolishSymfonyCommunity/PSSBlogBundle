<?php

namespace PSS\Bundle\BlogBundle\Manager;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


# Specific


# Domain objects


# Entities
use PSS\Bundle\BlogBundle\Entity\Post;



/**
 * Distribute and manipulate Post
 * 
 * 
 */
class PostManager extends AbstractManager
{
    const CLASSNAME = 'PSS\Bundle\BlogBundle\Entity\Post';

}