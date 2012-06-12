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
    const SHORTCUT  = 'PSSBlogBundle:Post';


    public function getPublishedQuery(){
        $query = $this->getRepository()->getPublishedPostsQuery();
        return $query;
    }

    public function getHilighted()
    {
        $array = $this->getPublishedQuery()->setMaxResults(3)->getResult();
        return new \Doctrine\Common\Collections\ArrayCollection($array);
    }
}