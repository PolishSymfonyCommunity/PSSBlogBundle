<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_postmeta")
 * @ORM\Entity
 */
class PostMeta
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="meta_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Post $post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="meta")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="ID")
     */
    private $post;

    /**
     * @var string $key
     *
     * @ORM\Column(name="meta_key", type="string", length=255, nullable=true)
     */
    private $key;

    /**
     * @var text $value
     *
     * @ORM\Column(name="meta_value", type="text", nullable=true)
     */
    private $value;

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
     * Set key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param text $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return text 
     */
    public function getValue()
    {
        return $this->value;
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
}