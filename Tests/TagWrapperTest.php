<?php

namespace PSS\Bundle\BlogBundle\Tests\TagWrapperTest;

use PSS\Bundle\BlogBundle\TagCloud\TagCloud;
use PSS\Bundle\BlogBundle\TagCloud\TagWrapper;

class Tag implements \PSS\Bundle\BlogBundle\TagCloud\TagInterface
{
    private $name = null;

    private $frequency = null;

    public function __construct($name, $frequency)
    {
        $this->name = $name;
        $this->frequency = $frequency;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function getSomething()
    {
        return 'done';
    }
}

class FakeTagCloud extends TagCloud
{
    public function getWeight()
    {
        return 'fake';
    }
}

class TagWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $tagWrapper = null;

    public function setUp()
    {
        $tag = new Tag('symfony', 3);
        $tagCloud = new FakeTagCloud(
            array($tag, new Tag('php', 5), new Tag('tdd', 2)),
            array('small', 'medium', 'large')
        );
        $this->tagWrapper = new TagWrapper($tag, $tagCloud);
    }

    public function testThatFrequencyAndNameAreTakenFromTag()
    {
        $this->assertEquals(3, $this->tagWrapper->getFrequency());
        $this->assertEquals('symfony', $this->tagWrapper->getName());
    }

    public function testThatWeightIsCalculatedByTagCloud()
    {
        $this->assertEquals('fake', $this->tagWrapper->getWeight());
    }

    public function testThatGetterCallsArePassedToTheOriginalTag()
    {
        $this->assertEquals('done', $this->tagWrapper->getSomething());
    }

    public function testThatNonGetterCallsAreConvertedToGetter()
    {
        $this->assertEquals('done', $this->tagWrapper->something());
    }

    public function testThatOriginalTagCanBeRetrieved()
    {
        $tag = $this->tagWrapper->getTag();

        $this->assertEquals(3, $tag->getFrequency());
        $this->assertEquals('symfony', $tag->getName());
    }
}

