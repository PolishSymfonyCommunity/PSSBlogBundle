<?php

namespace PSS\Bundle\BlogBundle\Manager;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


# Specific


# Domain objects


# Entities
use PSS\Bundle\BlogBundle\Entity\Comment;



/**
 * Distribute and manipulate Comments
 *
 * 
 */
class CommentManager extends AbstractManager
{
    const CLASSNAME = 'PSS\Bundle\BlogBundle\Entity\Comment';
    const SHORTCUT =  'PSSBlogBundle:Comment';
    
}