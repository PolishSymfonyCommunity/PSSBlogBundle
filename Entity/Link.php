<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
