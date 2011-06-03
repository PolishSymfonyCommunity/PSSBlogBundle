<?php

namespace PSS\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TermRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllTags()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT t, tt FROM PSS\Bundle\BlogBundle\Entity\Term t
             INNER JOIN t.termTaxonomies tt
             WHERE tt.count > 0 AND tt.taxonomy = \'post_tag\'
             ORDER by t.name ASC'
        );

        return $query->getResult();
    }
}
