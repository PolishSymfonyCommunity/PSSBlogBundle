<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_term_relationships")
 * @ORM\Entity
 */
class TermRelationship
{
    /**
     * @var integer $objectId
     *
     * @ORM\Column(name="object_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $objectId;

    /**
     * @var Link $link
     *
     * @ORM\ManyToOne(targetEntity="Link", inversedBy="termRelationships")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="link_id")
     */
    private $link;

    /**
     * @var Post $post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="termRelationships")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="ID")
     */
    private $post;

    /**
     * @var integer $termTaxonomyId
     *
     * @ORM\Column(name="term_taxonomy_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $termTaxonomyId;

    /**
     * @var TermTaxonomy $termTaxonomy
     *
     * @ORM\ManyToOne(targetEntity="TermTaxonomy", inversedBy="termRelationships")
     * @ORM\JoinColumn(name="term_taxonomy_id", referencedColumnName="term_taxonomy_id")
     */
    private $termTaxonomy;

    /**
     * @var integer $termOrder
     *
     * @ORM\Column(name="term_order", type="integer", nullable=false)
     */
    private $termOrder;


    /**
     * Set objectId
     *
     * @param bigint $objectId
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    }


    /**
     * Get objectId
     *
     * @return bigint 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }


    /**
     * Set termTaxonomyId
     *
     * @param bigint $termTaxonomyId
     */
    public function setTermTaxonomyId($termTaxonomyId)
    {
        $this->termTaxonomyId = $termTaxonomyId;
    }


    /**
     * Get termTaxonomyId
     *
     * @return bigint 
     */
    public function getTermTaxonomyId()
    {
        return $this->termTaxonomyId;
    }


    /**
     * Set termOrder
     *
     * @param integer $termOrder
     */
    public function setTermOrder($termOrder)
    {
        $this->termOrder = $termOrder;
    }


    /**
     * Get termOrder
     *
     * @return integer 
     */
    public function getTermOrder()
    {
        return $this->termOrder;
    }


    /**
     * Set link
     *
     * @param PSS\Bundle\BlogBundle\Entity\Link $link
     */
    public function setLink(\PSS\Bundle\BlogBundle\Entity\Link $link)
    {
        $this->link = $link;
    }


    /**
     * Get link
     *
     * @return PSS\Bundle\BlogBundle\Entity\Link 
     */
    public function getLink()
    {
        return $this->link;
    }


    /**
     * Set post
     *
     * @param PSS\Bundle\BlogBundle\Entity\Post $post
     */
    public function setPost(\PSS\Bundle\BlogBundle\Entity\Post $post)
    {
        $this->post = $post;
    }


    /**
     * Get post
     *
     * @return PSS\Bundle\BlogBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set termTaxonomy
     *
     * @param PSS\Bundle\BlogBundle\Entity\TermTaxonomy $termTaxonomy
     */
    public function setTermTaxonomy(\PSS\Bundle\BlogBundle\Entity\TermTaxonomy $termTaxonomy)
    {
        $this->termTaxonomy = $termTaxonomy;
    }

    /**
     * Get termTaxonomy
     *
     * @return PSS\Bundle\BlogBundle\Entity\TermTaxonomy 
     */
    public function getTermTaxonomy()
    {
        return $this->termTaxonomy;
    }
}