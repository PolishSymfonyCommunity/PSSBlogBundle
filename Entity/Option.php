<?php

namespace PSS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wp_options")
 * @ORM\Entity
 */
class Option
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="option_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $blogId
     *
     * @ORM\Column(name="blog_id", type="integer", nullable=false)
     */
    private $blogId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="option_name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var text $value
     *
     * @ORM\Column(name="option_value", type="text", nullable=false)
     */
    private $value;

    /**
     * @var string $autoload
     *
     * @ORM\Column(name="autoload", type="string", length=20, nullable=false)
     */
    private $autoload;

    public function setBlogId($blogId)
    {
        $this->blogId = $blogId;
    }

    public function getBlogId()
    {
        return $this->blogId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setAutoload($flag)
    {
        $this->autoload = $flag;
    }

    public function getAutoload()
    {
        return $this->autoload;
    }
}
