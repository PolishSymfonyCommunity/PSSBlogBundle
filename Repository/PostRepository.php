<?php

namespace PSS\Bundle\BlogBundle\Repository;

# Symfony/Doctrine internal
use Doctrine\ORM\EntityRepository;


# Specific


# Domain objects


# Entities
use PSS\Bundle\BlogBundle\Entity\TermTaxonomy;
use PSS\Bundle\BlogBundle\Entity\Post;


# Exceptions
use Doctrine\ORM\NoResultException;




class PostRepository extends AbstractRepository
{

    /**
     * @return Doctrine\ORM\QueryBuilder
     */
    public function getPublished( $max = null )
    {
        $qb =  $this->createQueryBuilder("p")
                    ->select('p,a')
                    ->innerJoin('p.author', 'a')
                    ->where('p.type = :type AND p.status = :status')
                    ->orderBy('p.publishedAt', 'DESC');

        if (is_numeric($max))
        {
            $qb->setMaxResults($limit);
        }

        $qb->setParameter('type', Post::TYPE_POST);
        $qb->setParameter('status', Post::STATUS_PUBLISH);

        return $qb;
    }

    /**
     * @return Doctrine\ORM\Query
     */
    public function getPublishedPostsQuery()
    {
        $qb = $this->getPublished();
        $qb->setParameter('type', Post::TYPE_POST);
        $qb->setParameter('status', Post::STATUS_PUBLISH);
        return $qb->getQuery();
    }



    /**
     * @param integer $max
     * @return PSS\Bundle\BlogBundle\Entity\Post
     */
    public function findPublishedPosts($max = 3)
    {
        $query = $this->getPublishedPostsQuery();
        $query->setMaxResults($max);

        return $query->getResult();
    }



    /**
     * @return Doctrine\ORM\Query
     */
    public function getPublishedPostsByTagQuery($tagSlug)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, a FROM PSS\Bundle\BlogBundle\Entity\Post p
             INNER JOIN p.author a
             INNER JOIN p.termRelationships tr
             INNER JOIN tr.termTaxonomy tt
             INNER JOIN tt.term t
             WHERE p.type = :type
               AND p.status = :status
               AND tt.taxonomy = :taxonomy
               AND t.slug = :slug
             ORDER BY p.publishedAt DESC'
        );

        $query->setParameter('type', Post::TYPE_POST);
        $query->setParameter('status', Post::STATUS_PUBLISH);
        $query->setParameter('slug', $tagSlug);
        $query->setParameter('taxonomy', TermTaxonomy::POST_TAG);

        return $query;
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
             AND p.status = :status
             AND p.type IN (:type_post, :type_page)'
        );

        $query->setParameter('status', Post::STATUS_PUBLISH);
        $query->setParameter('slug', $slug);
        $query->setParameter('type_post', Post::TYPE_POST);
        $query->setParameter('type_page', Post::TYPE_PAGE);

        return $query->getSingleResult();
    }
}
