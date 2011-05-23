<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wp_posts")
 * @ORM\Entity(repositoryClass="PSS\Bundle\BlogBundle\Repository\PostRepository")
 */
class Post
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
     * @var integer $category
     *
     * @ORM\Column(name="post_category", type="integer", nullable=false)
     */
    private $category;

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
}
