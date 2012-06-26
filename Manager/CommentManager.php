<?php

namespace PSS\Bundle\BlogBundle\Manager;

// Symfony/Doctrine internal
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


// Specific


// Domain objects
use PSS\Bundle\BlogBundle\Form\CommentForm;


// Entities
use PSS\Bundle\BlogBundle\Entity\Comment;


// Exceptions
use \Exception;
use \LogicException;






/**
 * Manages the lifecycle of a Organization
 */
class CommentManager extends AbstractManager
{
    const FORM_CLASSNAME = 'PSS\Bundle\BlogBundle\Form\CommentForm';

    const CLASSNAME = 'PSS\Bundle\BlogBundle\Entity\Comment';

    const SHORTCUT =  'PSSBlogBundle:Comment';
    
}