<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wp_term_taxonomy")
 * @ORM\Entity
 */
class TermTaxonomy
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="term_taxonomy_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $termId
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false)
     */
    private $termId;

    /**
     * @var Term $term
     *
     * @ORM\ManyToOne(targetEntity="Term", inversedBy="termTaxonomies")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="term_id")
     */
    private $term;

    /**
     * @var string $taxonomy
     *
     * @ORM\Column(name="taxonomy", type="string", length=32, nullable=false)
     */
    private $taxonomy;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="parent", type="bigint", nullable=false)
     */
    private $parentId;

    /**
     * @var integer $count
     *
     * @ORM\Column(name="count", type="bigint", nullable=false)
     */
    private $count;

    /**
     * @var Collection $termRelationships
     *
     * @ORM\OneToMany(targetEntity="TermRelationship", mappedBy="termTaxonomy")
     * @ORM\JoinColumn(name="term_taxonomy_id", referencedColumnName="term_taxonomy_id")
     */
    private $termRelationships;

    /**
     * @return integer
     */
    public function getPostCount()
    {
        return $this->count;
    }
}
