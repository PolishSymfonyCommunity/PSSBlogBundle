<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_links")
 * @ORM\Entity
 */
class Link
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="link_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $url
     *
     * @ORM\Column(name="link_url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string $name
     *
     * @ORM\Column(name="link_name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $image
     *
     * @ORM\Column(name="link_image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string $target
     *
     * @ORM\Column(name="link_target", type="string", length=25, nullable=false)
     */
    private $target;

    /**
     * @var integer $category
     *
     * @ORM\Column(name="link_category", type="bigint", nullable=false)
     */
    private $category;

    /**
     * @var string $description
     *
     * @ORM\Column(name="link_description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string $visible
     *
     * @ORM\Column(name="link_visible", type="string", length=20, nullable=false)
     */
    private $visible;

    /**
     * @var integer $owner
     *
     * @ORM\Column(name="link_owner", type="bigint", nullable=false)
     */
    private $owner;

    /**
     * @var integer $rating
     *
     * @ORM\Column(name="link_rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="link_updated", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var string $rel
     *
     * @ORM\Column(name="link_rel", type="string", length=255, nullable=false)
     */
    private $rel;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="link_notes", type="text", nullable=false)
     */
    private $notes;

    /**
     * @var string $rss
     *
     * @ORM\Column(name="link_rss", type="string", length=255, nullable=false)
     */
    private $rss;

    /**
     * @var Collection $termRelationships
     *
     * @ORM\OneToMany(targetEntity="TermRelationship", mappedBy="link")
     * @ORM\JoinColumn(name="link_id", referencedColumnName="object_id")
     */
    private $termRelationships;
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set target
     *
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set category
     *
     * @param bigint $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return bigint 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set visible
     *
     * @param string $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * Get visible
     *
     * @return string 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set owner
     *
     * @param bigint $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return bigint 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set rel
     *
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * Get rel
     *
     * @return string 
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set rss
     *
     * @param string $rss
     */
    public function setRss($rss)
    {
        $this->rss = $rss;
    }

    /**
     * Get rss
     *
     * @return string 
     */
    public function getRss()
    {
        return $this->rss;
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