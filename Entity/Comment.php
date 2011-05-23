<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
