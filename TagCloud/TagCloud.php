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
 * Class solves a problem of a tag weight calculation.
 *
 * Example usage:
 *
 * <code>
 * // example Tag implementation
 * class Tag implements PSS\Bundle\BlogBundle\TagCloud\TagInterface
 * {
 *  private $name = null;
 *
 *  private $frequency = null;
 *
 *  public function __construct($name, $frequency)
 *  {
 *      $this->name = $name;
 *      $this->frequency = $frequency;
 *  }
 *
 *  public function getName()
 *  {
 *      return $this->name;
 *  }
 *
 *  public function getFrequency()
 *  {
 *      return $this->frequency;
 *  }
 * }
 *
 * // List of tags
 * $tags = array(array(new Tag('php', 1), new Tag('symfony', 4), new Tag('tdd', 2), new Tag('Symfony2', 7)));
 * // List of tag weights ordered from smallest to the largest
 * $weights = array('small', 'big', 'large');
 *
 * $tagCloud = new TagCloud($tags, $weights);
 * // Get weight for frequency
 * $weight = $tagCloud->getWeight(4);
 * // Get weight for tag
 * $weight = $tagCloud->getWeightByTag('symfony');
 * </code>
 *
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class TagCloud
{
    /**
     * @var array $tags
     */
    private $tags = array();

    /**
     * @var array $weights
     */
    private $weights = array();

    /**
     * @var integer $maxFrequency
     */
    private $maxFrequency = 0;

    /**
     * @var integer $minFrequency
     */
    private $minFrequency = 0;

    /**
     * @param array $tags
     * @param array $weights
     * @return null
     */
    public function __construct(array $tags, array $weights)
    {
        if (count($weights) == 0) {
            throw new \InvalidArgumentException('You need to give a list of tag weights');
        }

        $this->weights = $weights;

        shuffle($tags);

        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    /**
     * @param TagInterface $tag
     * @return null
     */
    public function addTag(TagInterface $tag)
    {
        $this->tags[$tag->getName()] = new TagWrapper($tag, $this);

        $this->updateMinAndMaxFrequency($tag->getFrequency());
    }

    /**
     * @param integer $frequency
     * @return null
     */
    protected function updateMinAndMaxFrequency($frequency)
    {
        if ($this->minFrequency > $frequency || 0 == $this->minFrequency) {
            $this->minFrequency = $frequency;
        }

        if ($this->maxFrequency < $frequency) {
            $this->maxFrequency = $frequency;
        }
    }

    /**
     * Returns array of TagWrapper objects.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param integer $frequency
     * @return string
     */
    public function getWeight($frequency)
    {
        if ($frequency <= $this->minFrequency) {
            return $this->weights[0];
        }

        $maxWeight = count($this->weights);
        $weight = ($maxWeight * ($frequency - $this->minFrequency)) / ($this->maxFrequency - $this->minFrequency);
        $weightIndex = $weight - 1;

        return isset($this->weights[$weightIndex]) ? $this->weights[$weightIndex] : $this->weights[$maxWeight - 1];
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function getWeightForTagName($tagName)
    {
        return isset($this->tags[$tagName]) ? $this->getWeight($this->tags[$tagName]->getFrequency()) : $this->weights[0];
    }
}

