<?php

namespace PSS\Bundle\BlogBundle\Entity;


// Symfony/Doctrine internal
use \Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;


// Specific


// Domain objects


// Entities


// Exceptions
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




/**
 * @ORM\Table(name="wp_posts")
 * @ORM\Entity(repositoryClass="PSS\Bundle\BlogBundle\Repository\PostRepository")
 */
class Post
{
    const STATUS_PUBLISH    = 'publish';
    const STATUS_INHERIT    = 'inherit';
    const STATUS_DRAFT      = 'draft';
    const STATUS_AUTO_DRAFT = 'auto-draft';

    const TYPE_ATTACHMENT   = 'attachment';
    const TYPE_PAGE         = 'page';
    const TYPE_POST         = 'post';
    const TYPE_REVISION     = 'revision';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User $author
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="post_author", referencedColumnName="ID", onDelete="CASCADE")
     */
    private $author;

    /**
     * @var DateTime $publishedAt
     *
     * @ORM\Column(name="post_date", type="datetime", nullable=false)
     */
    private $publishedAt;

    /**
     * @var DateTime $publishedAtAsGmt
     *
     * @ORM\Column(name="post_date_gmt", type="datetime", nullable=false)
     */
    private $publishedAtAsGmt;

    /**
     * @var text $content
     *
     * @ORM\Column(name="post_content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var text $title
     *
     * @ORM\Column(name="post_title", type="text", nullable=false)
     */
    private $title;

    /**
     * @var text $excerpt
     *
     * @ORM\Column(name="post_excerpt", type="text", nullable=false)
     */
    private $excerpt;

    /**
     * @var string $postStatus
     *
     * @ORM\Column(name="post_status", type="string", length=20, nullable=false)
     */
    private $status;

    /**
     * @var string $commentStatus
     *
     * @ORM\Column(name="comment_status", type="string", length=20, nullable=false)
     */
    private $commentStatus;

    /**
     * @var string $pingStatus
     *
     * @ORM\Column(name="ping_status", type="string", length=20, nullable=false)
     */
    private $pingStatus;

    /**
     * @var string $password
     *
     * @ORM\Column(name="post_password", type="string", length=20, nullable=false)
     */
    private $password;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="post_name", type="string", length=200, nullable=false)
     */
    private $slug;

    /**
     * @var text $toPing
     *
     * @ORM\Column(name="to_ping", type="text", nullable=false)
     */
    private $toPing;

    /**
     * @var text $pinged
     *
     * @ORM\Column(name="pinged", type="text", nullable=false)
     */
    private $pinged;

    /**
     * @var DateTime $modifiedAt
     *
     * @ORM\Column(name="post_modified", type="datetime", nullable=false)
     */
    private $modifiedAt;

    /**
     * @var DateTime $modifiedAtAsGmt
     *
     * @ORM\Column(name="post_modified_gmt", type="datetime", nullable=false)
     */
    private $modifiedAtAsGmt;

    /**
     * @var text $contentFiltered
     *
     * @ORM\Column(name="post_content_filtered", type="text", nullable=false)
     */
    private $contentFiltered;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="post_parent", type="bigint", nullable=false)
     * @ORM\JoinColumn(name="post_parent", referencedColumnName="ID")
     */
    private $parentId;

    /**
     * @var string $guid
     *
     * @ORM\Column(name="guid", type="string", length=255, nullable=false)
     */
    private $guid;

    /**
     * @var integer $menuOrder
     *
     * @ORM\Column(name="menu_order", type="integer", nullable=false)
     */
    private $menuOrder;

    /**
     * @var string $type
     *
     * @ORM\Column(name="post_type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var string $postMimeType
     *
     * @ORM\Column(name="post_mime_type", type="string", length=100, nullable=false)
     */
    private $mimeType;

    /**
     * @var integer $commentCount
     *
     * @ORM\Column(name="comment_count", type="bigint", nullable=false)
     */
    private $commentCount;

    /**
     * @var Collection $comments
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     * @ORM\JoinColumn(name="ID", referencedColumnName="comment_ID")
     */
    private $comments;

    /**
     * @var Collection $meta
     *
     * @ORM\OneToMany(targetEntity="PostMeta", mappedBy="post")
     * @ORM\JoinColumn(name="ID", referencedColumnName="post_id")
     */
    private $meta;

    /**
     * @var Collection $termRelationships
     *
     * @ORM\OneToMany(targetEntity="TermRelationship", mappedBy="post")
     * @ORM\JoinColumn(name="ID", referencedColumnName="object_id")
     */
    private $termRelationships;

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * @return integer
     */
    public function getYear()
    {
        $date = $this->getPublishedAt();
        return $date->format('Y');
    }


    /**
     * @return integer
     */
    public function getMonth()
    {
        $date = $this->getPublishedAt();
        return $date->format('m');
    }



    /**
     * Validate if post is set as published
     *
     * @return Post   The post
     * @throws NotFoundHttpException  If post status is NOT to "publish"
     */
    public function onlyIfPublished(){
        if($this->status != static::STATUS_PUBLISH)
        {
            throw new NotFoundHttpException('Page Not Found');
        }
        return $this;
    }


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->meta = new ArrayCollection();
        $this->termRelationships = new ArrayCollection();
    }


    /**
     * Get moderated comments
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getModeratedComments()
    {
        $approved = new ArrayCollection();
        foreach ($this->comments as $comment) {
            if ($comment->getApproved() === true) {
                $approved[] = $comment;
            }
        }
        return $approved;
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
     * Set publishedAt
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * Set publishedAtAsGmt
     *
     * @param datetime $publishedAtAsGmt
     */
    public function setPublishedAtAsGmt($publishedAtAsGmt)
    {
        $this->publishedAtAsGmt = $publishedAtAsGmt;
    }

    /**
     * Get publishedAtAsGmt
     *
     * @return datetime 
     */
    public function getPublishedAtAsGmt()
    {
        return $this->publishedAtAsGmt;
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
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set excerpt
     *
     * @param text $excerpt
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set commentStatus
     *
     * @param string $commentStatus
     */
    public function setCommentStatus($commentStatus)
    {
        $this->commentStatus = $commentStatus;
    }

    /**
     * Get commentStatus
     *
     * @return string 
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set pingStatus
     *
     * @param string $pingStatus
     */
    public function setPingStatus($pingStatus)
    {
        $this->pingStatus = $pingStatus;
    }

    /**
     * Get pingStatus
     *
     * @return string 
     */
    public function getPingStatus()
    {
        return $this->pingStatus;
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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set toPing
     *
     * @param text $toPing
     */
    public function setToPing($toPing)
    {
        $this->toPing = $toPing;
    }

    /**
     * Get toPing
     *
     * @return text 
     */
    public function getToPing()
    {
        return $this->toPing;
    }

    /**
     * Set pinged
     *
     * @param text $pinged
     */
    public function setPinged($pinged)
    {
        $this->pinged = $pinged;
    }

    /**
     * Get pinged
     *
     * @return text 
     */
    public function getPinged()
    {
        return $this->pinged;
    }

    /**
     * Set modifiedAt
     *
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * Get modifiedAt
     *
     * @return datetime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedAtAsGmt
     *
     * @param datetime $modifiedAtAsGmt
     */
    public function setModifiedAtAsGmt($modifiedAtAsGmt)
    {
        $this->modifiedAtAsGmt = $modifiedAtAsGmt;
    }

    /**
     * Get modifiedAtAsGmt
     *
     * @return datetime 
     */
    public function getModifiedAtAsGmt()
    {
        return $this->modifiedAtAsGmt;
    }

    /**
     * Set contentFiltered
     *
     * @param text $contentFiltered
     */
    public function setContentFiltered($contentFiltered)
    {
        $this->contentFiltered = $contentFiltered;
    }

    /**
     * Get contentFiltered
     *
     * @return text 
     */
    public function getContentFiltered()
    {
        return $this->contentFiltered;
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
     * Set guid
     *
     * @param string $guid
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    /**
     * Get guid
     *
     * @return string 
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set menuOrder
     *
     * @param integer $menuOrder
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menuOrder = $menuOrder;
    }

    /**
     * Get menuOrder
     *
     * @return integer 
     */
    public function getMenuOrder()
    {
        return $this->menuOrder;
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
     * Set mimeType
     *
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set commentCount
     *
     * @param bigint $commentCount
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }

    /**
     * Get commentCount
     *
     * @return bigint 
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set author
     *
     * @param PSS\Bundle\BlogBundle\Entity\User $author
     */
    public function setAuthor(\PSS\Bundle\BlogBundle\Entity\User $author)
    {
        $this->author = $author;
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add meta
     *
     * @param PSS\Bundle\BlogBundle\Entity\PostMeta $meta
     */
    public function addPostMeta(\PSS\Bundle\BlogBundle\Entity\PostMeta $meta)
    {
        $this->meta[] = $meta;
    }

    /**
     * Get meta
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMeta()
    {
        return $this->meta;
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTermRelationships()
    {
        return $this->termRelationships;
    }
}