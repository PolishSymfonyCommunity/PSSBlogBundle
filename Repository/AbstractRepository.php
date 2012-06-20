<?php

namespace PSS\Bundle\BlogBundle\Repository;

# Symfony/Doctrine internal
use \Doctrine\ORM\EntityRepository;
use \Doctrine\Common\Collections\ArrayCollection;
use \Doctrine\ORM\Query;


# Specific


# Domain objects


# Entities



abstract class AbstractRepository extends EntityRepository
{
    /**
     * Use Doctrine Debug
     */
    public function debugDump($in)
    {
        throw new \Exception('Debugging result:'.\Doctrine\Common\Util\Debug::dump($in));
    }


    /**
     * Show DQL from a Query object
     */
    protected function debugDql(Query $in)
    {
        throw new \Exception('Debugging query:'.$in->getDQL());
    }



    /**
     * Convert Array to ArrayCollection
     * 
     * @param  array $array    
     * @return ArrayCollection
     */
    public function toCollection($array)
    {
        return $this->_toCollection($array);
    }   


    /**
     * Return the first Entity class
     * 
     * @param  QueryBuilder $qb    a QueryBuilder instance
     * @return Object              an Entity object
     */
    protected function _fistInCollectionFromQueryBuilder(QueryBuilder $qb)
    {
        $collection = $this->_collectionFromQueryBuilder($qb);
        return $collection->first();
    }


    /**
     * Convert a result Collection based on QueryBuilder
     * 
     * @param  QueryBuilder $qb    a QueryBuilder instance
     * @return Object              an Entity object
     */
    protected function _collectionFromQueryBuilder(QueryBuilder $qb)
    {
        $result = $qb->getQuery()->getResult();
        return $this->_toCollection($result);
    }


    protected function _toCollection($result)
    {
        return new \Doctrine\Common\Collections\ArrayCollection($result);
    }    
}