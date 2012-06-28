<?php

namespace PSS\Bundle\BlogBundle\Repository;

// Symfony/Doctrine internal
use Doctrine\ORM\EntityRepository;


// Specific


// Domain objects


// Entities
use PSS\Bundle\BlogBundle\Entity\TermTaxonomy;
use PSS\Bundle\BlogBundle\Entity\Post;
use PSS\Bundle\BlogBundle\TagCloud\TagInterface;
use PSS\Bundle\BlogBundle\Entity\Term;


// Exceptions
use Doctrine\ORM\NoResultException;




class PostRepository extends AbstractRepository
{
    /**
     * @return Doctrine\ORM\QueryBuilder
     */
    public function getPublished( $max = null )
    {
        $this->qb =  $this->createQueryBuilder("p")
                    ->select('p,a')
                    ->innerJoin('p.author', 'a')
                    ->where('p.type = :type')
                    ->andWhere('p.status = :status')
                    ->orderBy('p.publishedAt', 'DESC');

        if (is_numeric($max))
        {
            $this->qb->setMaxResults($max);
        }

        $this->qb->setParameter('type', Post::TYPE_POST);
        $this->qb->setParameter('status', Post::STATUS_PUBLISH);

        return $this->qb;
    }

    /**
     * @return Doctrine\ORM\QueryBuilder
     */
    public function getPublishedByTerm(Term $term=null)
    {
        $this->qb = $this->getPublished()
                    ->innerJoin('p.termRelationships', 'tr')
                    ->innerJoin('tr.termTaxonomy', 'tt')
                    ->innerJoin('tt.term','t')
                    ->andWhere('tt.taxonomy = :taxonomy')
                    ->andWhere('t.slug = :slug');

        $this->qb->setParameter('slug', $term->getSlug());
        $this->qb->setParameter('taxonomy', TermTaxonomy::POST_TAG);

        return $this->qb;
    }    

    /**
     * Get three last hilighted
     */
    public function getHilighted()
    {
        $slugs = array('Favourites','Linux');

        $this->qb = $this->getPublished()
                    ->innerJoin('p.termRelationships', 'tr')
                    ->innerJoin('tr.termTaxonomy', 'tt')
                    ->innerJoin('tt.term','t')
                    ->andWhere('tt.taxonomy = :taxonomy')
                    ->andWhere($this->qb->expr()->in('t.slug',$slugs))
                    ->orderBy('p.publishedAt','DESC');

        $this->qb->setParameter('taxonomy', TermTaxonomy::POST_TAG);
        $this->qb->setMaxResults(3);

        return $this->qb;
    }

    /**
     * Get a list of posts by Tag slug
     *
     * @param array $slugs  List of slugs to search in
     * @param int   $max    Limit Max results
     *
     * @return QueryBuilder
     */
    public function getByTagSlugs(array $slugs,$max=3)
    {
        $this->qb = $this->getPublished()
                    ->innerJoin('p.termRelationships', 'tr')
                    ->innerJoin('tr.termTaxonomy', 'tt')
                    ->innerJoin('tt.term','t')
                    ->andWhere('tt.taxonomy = :taxonomy')
                    ->andWhere($this->qb->expr()->in('t.slug',$slugs))
                    ->orderBy('p.publishedAt','DESC');

        $this->qb->setParameter('taxonomy', TermTaxonomy::POST_TAG);
        $this->qb->setMaxResults($max);

        return $this->qb;
    }

    /**
     * Get a list of posts by Category slug 
     *
     * @param array $slugs  List of slugs to search in
     * @param int   $max    Limit Max results
     *
     * @return QueryBuilder
     */
    public function getByCategorySlugs(array $slugs,$max=3)
    {
        $this->qb = $this->getByTagSlugs($slugs,$max);
        $this->qb->setParameter('taxonomy', TermTaxonomy::CATEGORY);

        return $this->qb;
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
        $this->qb = $this->getPublishedByTerm()
					->setParameter('slug', $tagSlug);

        return $this->qb->getQuery();
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
