<?php

/*
 * This file is part of the PSSBlogBundle package.
 *
 * (c) Jakub Zalas <jakub@zalas.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PSS\Bundle\BlogBundle\TagCloud;

/**
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class TagWrapper implements TagInterface
{
    /**
     * @var TagInterface $tag
     */
    private $tag = null;

    /**
     * @var TagCloud $tagCloud
     */
    private $tagCloud = null;

    /**
     * @param TagInterface $tag
     * @param TagCloud $tagCloud
     * @return null
     */
    public function __construct(TagInterface $tag, TagCloud $tagCloud)
    {
        $this->tag = $tag;
        $this->tagCloud = $tagCloud;
    }

    /**
     * @return integer
     */
    public function getFrequency()
    {
        return $this->tag->getFrequency();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->tag->getName();
    }

    /**
     * @return TagInterface
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->tagCloud->getWeight($this->getFrequency());
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (strpos($method, 'get') !== 0) {
            $method = 'get' . ucfirst($method);
        }

        return $this->tag->$method();
    }
}
