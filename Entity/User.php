<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_users")
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $login
     *
     * @ORM\Column(name="user_login", type="string", length=60, nullable=false)
     */
    private $login;

    /**
     * @var string $password
     *
     * @ORM\Column(name="user_pass", type="string", length=64, nullable=false)
     */
    private $password;

    /**
     * @var string $niceName
     *
     * @ORM\Column(name="user_nicename", type="string", length=50, nullable=false)
     */
    private $niceName;

    /**
     * @var string $email
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string $url
     *
     * @ORM\Column(name="user_url", type="string", length=100, nullable=false)
     */
    private $url;

    /**
     * @var datetime $registeredAt
     *
     * @ORM\Column(name="user_registered", type="datetime", nullable=false)
     */
    private $registeredAt;

    /**
     * @var string $activationKey
     *
     * @ORM\Column(name="user_activation_key", type="string", length=60, nullable=false)
     */
    private $activationKey;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="user_status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var string $displayName
     *
     * @ORM\Column(name="display_name", type="string", length=250, nullable=false)
     */
    private $displayName;

    /**
     * @var Collection $posts
     *
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     * @ORM\JoinColumn(name="ID", referencedColumnName="post_author")
     */
    private $posts;

    /**
     * @var Collection $comments
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     * @ORM\JoinColumn(name="ID", referencedColumnName="user_id")
     */
    private $comments;

    /**
     * @var Collection $meta
     *
     * @ORM\OneToMany(targetEntity="UserMeta", mappedBy="user")
     * @ORM\JoinColumn(name="ID", referencedColumnName="user_id")
     */
    private $meta;

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    $this->meta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set niceName
     *
     * @param string $niceName
     */
    public function setNiceName($niceName)
    {
        $this->niceName = $niceName;
    }

    /**
     * Get niceName
     *
     * @return string 
     */
    public function getNiceName()
    {
        return $this->niceName;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set registeredAt
     *
     * @param datetime $registeredAt
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;
    }

    /**
     * Get registeredAt
     *
     * @return datetime 
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set activationKey
     *
     * @param string $activationKey
     */
    public function setActivationKey($activationKey)
    {
        $this->activationKey = $activationKey;
    }

    /**
     * Get activationKey
     *
     * @return string 
     */
    public function getActivationKey()
    {
        return $this->activationKey;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Add posts
     *
     * @param PSS\Bundle\BlogBundle\Entity\Post $posts
     */
    public function addPost(\PSS\Bundle\BlogBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add comments
     *
     * @param PSS\Bundle\BlogBundle\Entity\Comment $comments
     */
    public function addComment(\PSS\Bundle\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add meta
     *
     * @param PSS\Bundle\BlogBundle\Entity\UserMeta $meta
     */
    public function addUserMeta(\PSS\Bundle\BlogBundle\Entity\UserMeta $meta)
    {
        $this->meta[] = $meta;
    }

    /**
     * Get meta
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMeta()
    {
        return $this->meta;
    }
}