<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
