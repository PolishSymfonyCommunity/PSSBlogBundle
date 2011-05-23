<?php

namespace PSS\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @param integer $max
     * @return array
     */
    public function findPublishedPosts($max = 3)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, a FROM PSS\Bundle\BlogBundle\Entity\Post p
             INNER JOIN p.author a
             WHERE p.type = \'post\' AND p.status = \'publish\'
             ORDER BY p.publishedAt DESC'
        );

        $query->setMaxResults($max);

        return $query->getResult();
    }

    /**
     * @param string $slug
     * @return PSS\Bundle\BlogBundle\Entity\Post
     */
    public function findPublishedPostOrPage($slug)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM PSS\Bundle\BlogBundle\Entity\Post p
             WHERE p.slug = :slug
             AND p.status = \'publish\'
             AND p.type IN (\'post\', \'page\')'
        );

        $query->setParameter('slug', $slug);

        return $query->getSingleResult();
    }
}
