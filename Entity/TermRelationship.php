<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
