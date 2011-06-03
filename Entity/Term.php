<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wp_terms")
 * @ORM\Entity(repositoryClass="PSS\Bundle\BlogBundle\Repository\TermRepository")
 */
class Term
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=200, nullable=false)
     */
    private $slug;

    /**
     * @var integer $group
     *
     * @ORM\Column(name="term_group", type="bigint", nullable=false)
     */
    private $group;

    /**
     * @var Collection $termTaxonomies
     *
     * @ORM\OneToMany(targetEntity="TermTaxonomy", mappedBy="term")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="term_id")
     */
    private $termTaxonomies;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return integer
     */
    public function getPostCount()
    {
        if (is_null($this->termTaxonomies) || $this->termTaxonomies->isEmpty()) {
            return 0;
        }

        $termTaxonomy = $this->termTaxonomies->first();

        return $termTaxonomy->getPostCount();
    }
}
