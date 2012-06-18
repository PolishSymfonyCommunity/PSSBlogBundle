<?php

namespace PSS\Bundle\BlogBundle\Repository;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityRepository;
use \Doctrine\Common\Collections\ArrayCollection;


# Specific


# Domain objects


# Entities
use PSS\Bundle\BlogBundle\Entity\TermTaxonomy;
use PSS\Bundle\BlogBundle\Entity\Post;



abstract class AbstractRepository extends EntityRepository
{

    /**
     * Convert Array to ArrayCollection
     * 
     * @param  array $array    
     * @return ArrayCollection
     */
    public function toCollection($array)
    {
        return ArrayCollection($array);
    }   
}