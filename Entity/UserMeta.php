<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_usermeta")
 * @ORM\Entity
 */
class UserMeta
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="umeta_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Comment $user
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meta")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     */
    private $user;

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
     * Set user
     *
     * @param PSS\Bundle\BlogBundle\Entity\User $user
     */
    public function setUser(\PSS\Bundle\BlogBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return PSS\Bundle\BlogBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}