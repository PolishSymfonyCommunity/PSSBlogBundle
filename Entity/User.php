<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
