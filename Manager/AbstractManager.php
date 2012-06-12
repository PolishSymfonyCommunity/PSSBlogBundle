<?php

namespace PSS\Bundle\BlogBundle\Manager;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


# Specific


# Domain objects


# Entities




abstract class AbstractManager 
{

    /* @var \Doctrine\ORM\EntityManager */
    protected $em = null;


    /* @var \Symfony\Component\EventDispatcher\EventDispatcher */
    protected $dispatcher = null;


    public function __construct(EventDispatcher $dispatcher, EntityManager $em)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
    }
}