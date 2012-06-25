<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use Doctrine\ORM\Mapping as ORM;


// Specific


// Domain objects


// Entities




/**
 * @ORM\Table(name="wp_comments")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="comment_ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Post $post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="comment_post_ID", referencedColumnName="ID")
     */
    private $post;

    /**
     * @var text $authorName
     *
     * @ORM\Column(name="comment_author", type="text", nullable=false)
     */
    private $authorName;

    /**
     * @var string $authorEmail
     *
     * @ORM\Column(name="comment_author_email", type="string", length=100, nullable=false)
     */
    private $authorEmail;

    /**
     * @var string $authorUrl
     *
     * @ORM\Column(name="comment_author_url", type="string", length=200, nullable=false)
     */
    private $authorUrl;

    /**
     * @var string $authorIp
     *
     * @ORM\Column(name="comment_author_IP", type="string", length=100, nullable=false)
     */
    private $authorIp;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="comment_date", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $createdAtAsGmt
     *
     * @ORM\Column(name="comment_date_gmt", type="datetime", nullable=false)
     */
    private $createdAtAsGmt;

    /**
     * @var text $content
     *
     * @ORM\Column(name="comment_content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var integer $karma
     *
     * @ORM\Column(name="comment_karma", type="integer", nullable=false)
     */
    private $karma;

    /**
     * @var string $approved
     *
     * @ORM\Column(name="comment_approved", type="string", length=20, nullable=false)
     */
    private $approved;

    /**
     * @var string $agent
     *
     * @ORM\Column(name="comment_agent", type="string", length=255, nullable=false)
     */
    private $agent;

    /**
     * @var string $type
     *
     * @ORM\Column(name="comment_type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var bigint $parentId
     *
     * @ORM\Column(name="comment_parent", type="bigint", nullable=false)
     */
    private $parentId;

    /**
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     */
    private $user;

    /**
     * @var Collection $meta
     *
     * @ORM\OneToMany(targetEntity="CommentMeta", mappedBy="comment")
     * @ORM\JoinColumn(name="comment_ID", referencedColumnName="comment_id")
     */
    private $meta;



    public function __construct()
    {
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
     * Set authorName
     *
     * @param text $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * Get authorName
     *
     * @return text 
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * Get authorEmail
     *
     * @return string 
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Set authorUrl
     *
     * @param string $authorUrl
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;
    }

    /**
     * Get authorUrl
     *
     * @return string 
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * Set authorIp
     *
     * @param string $authorIp
     */
    public function setAuthorIp($authorIp)
    {
        $this->authorIp = $authorIp;
    }

    /**
     * Get authorIp
     *
     * @return string 
     */
    public function getAuthorIp()
    {
        return $this->authorIp;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAtAsGmt
     *
     * @param datetime $createdAtAsGmt
     */
    public function setCreatedAtAsGmt($createdAtAsGmt)
    {
        $this->createdAtAsGmt = $createdAtAsGmt;
    }

    /**
     * Get createdAtAsGmt
     *
     * @return datetime 
     */
    public function getCreatedAtAsGmt()
    {
        return $this->createdAtAsGmt;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set karma
     *
     * @param integer $karma
     */
    public function setKarma($karma)
    {
        $this->karma = $karma;
    }

    /**
     * Get karma
     *
     * @return integer 
     */
    public function getKarma()
    {
        return $this->karma;
    }

    /**
     * Set approved
     *
     * @param string $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * Get approved
     *
     * @return string 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set agent
     *
     * @param string $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

    /**
     * Get agent
     *
     * @return string 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * Add meta
     *
     * @param PSS\Bundle\BlogBundle\Entity\CommentMeta $meta
     */
    public function addCommentMeta(\PSS\Bundle\BlogBundle\Entity\CommentMeta $meta)
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