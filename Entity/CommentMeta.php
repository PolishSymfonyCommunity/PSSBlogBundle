<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wp_commentmeta")
 * @ORM\Entity
 */
class CommentMeta
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
     * @var Comment $comment
     *
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="meta")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="comment_ID")
     */
    private $comment;

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
}
