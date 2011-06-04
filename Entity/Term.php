<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PSS\Bundle\BlogBundle\Entity\TermTaxonomy;

/**
 * @ORM\Table(name="wp_terms")
 * @ORM\Entity(repositoryClass="PSS\Bundle\BlogBundle\Repository\TermRepository")
 */
class Term implements \PSS\Bundle\BlogBundle\TagCloud\TagInterface
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
    public function getFrequency()
    {
        return $this->getPostCount();
    }

    /**
     * @return integer
     */
    public function getPostCount()
    {
        $termTaxonomy = $this->getPostTagTaxonomy();

        return is_null($termTaxonomy) ? 0 : $termTaxonomy->getPostCount();
    }

    /**
     * @return PSS\Bundle\BlogBundle\Entity\TermTaxonomy
     */
    private function getPostTagTaxonomy()
    {
        if (!is_null($this->termTaxonomies)) {
            foreach ($this->termTaxonomies as $termTaxonomy) {
                if (TermTaxonomy::POST_TAG  == $termTaxonomy->getTaxonomy()) {
                    return $termTaxonomy;
                }
            }
        }

        return null;
    }
}
