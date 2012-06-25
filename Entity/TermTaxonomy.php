<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_term_taxonomy")
 * @ORM\Entity
 */
class TermTaxonomy
{
    const POST_TAG      = 'post_tag';
    const CATEGORY      = 'category';
    const LINK_CATEGORY = 'link_category';

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
     * @return string
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * @return integer
     */
    public function getPostCount()
    {
        return $this->count;
    }


    public function __construct()
    {
        $this->termRelationships = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Get id
     *
     * @return bigint 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set termId
     *
     * @param bigint $termId
     */
    public function setTermId($termId)
    {
        $this->termId = $termId;
    }

    /**
     * Get termId
     *
     * @return bigint 
     */
    public function getTermId()
    {
        return $this->termId;
    }

    /**
     * Set taxonomy
     *
     * @param string $taxonomy
     */
    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set parentId
     *
     * @param bigint $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get parentId
     *
     * @return bigint 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set count
     *
     * @param bigint $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return bigint 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set term
     *
     * @param PSS\Bundle\BlogBundle\Entity\Term $term
     */
    public function setTerm(\PSS\Bundle\BlogBundle\Entity\Term $term)
    {
        $this->term = $term;
    }

    /**
     * Get term
     *
     * @return PSS\Bundle\BlogBundle\Entity\Term 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Add termRelationships
     *
     * @param PSS\Bundle\BlogBundle\Entity\TermRelationship $termRelationships
     */
    public function addTermRelationship(\PSS\Bundle\BlogBundle\Entity\TermRelationship $termRelationships)
    {
        $this->termRelationships[] = $termRelationships;
    }

    /**
     * Get termRelationships
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTermRelationships()
    {
        return $this->termRelationships;
    }
}