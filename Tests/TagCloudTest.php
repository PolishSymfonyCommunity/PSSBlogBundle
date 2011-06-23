<?php

namespace PSS\Bundle\BlogBundle\Tests\TagCloudTest;

use PSS\Bundle\BlogBundle\TagCloud\TagCloud;

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
}

class TagCloudTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testThatAtLeastOneWeightIsRequired()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 10)), array());
    }

    public function testThatFrequencyOutOfRangeHasMaximumWeight()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 2), new Tag('php', 10)), array('small', 'big', 'large'));

        $this->assertEquals('large', $tagCloud->getWeight(400));
    }

    public function testThatTooSmallFrequencyHasMinimumWeight()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 200), new Tag('php', 300)), array('small', 'big', 'large'));

        $this->assertEquals('small', $tagCloud->getWeight(1));
    }

    public function testThatWeightCanBeRetrievedByTagName()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 2), new Tag('php', 10)), array('small', 'big', 'large'));

        $this->assertEquals('small', $tagCloud->getWeightForTagName('symfony'));
        $this->assertEquals('large', $tagCloud->getWeightForTagName('php'));
    }

    public function testThatWeightForTagOutsideOfCloudIsMinimal()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 2), new Tag('php', 10)), array('small', 'big', 'large'));

        $this->assertEquals('small', $tagCloud->getWeightForTagName('tdd'));
    }

    /**
     * @dataProvider getTags
     */
    public function testWeightDistribution($sizes, $tags, $expectedWeights)
    {
        $tagCloud = new TagCloud($tags, $sizes);

        foreach ($expectedWeights as $tagName => $size) {
            $this->assertEquals($size, $tagCloud->getWeightForTagName($tagName), sprintf('Tag "%s" is "%s"', $tagName, $size));
        }
    }

    public static function getTags()
    {
        return array(
            array(
                array('small'),
                array(new Tag('symfony', 1)),
                array('symfony' => 'small')
            ),
            array(
                array('small'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2)),
                array('symfony' => 'small', 'Symfony2' => 'small')
            ),
            array(
                array('small'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small')
            ),

            array(
                array('small', 'big'),
                array(new Tag('symfony', 1)),
                array('symfony' => 'small')
            ),
            array(
                array('small', 'big'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2)),
                array('symfony' => 'small', 'Symfony2' => 'big')
            ),
            array(
                array('small', 'big'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'big')
            ),
            array(
                array('small', 'big'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small', 'tdd' => 'big')
            ),

            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1)),
                array('symfony' => 'small')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2)),
                array('symfony' => 'small', 'Symfony2' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'big', 'tdd' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4), new Tag('bdd', 5)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small', 'tdd' => 'big', 'bdd' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4), new Tag('bdd', 5), new Tag('ui', 6)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small', 'tdd' => 'small', 'bdd' => 'big', 'ui' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4), new Tag('bdd', 5), new Tag('ui', 6), new Tag('phpunit', 7)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small', 'tdd' => 'small', 'bdd' => 'big', 'ui' => 'big', 'phpunit' => 'large')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 11), new Tag('Symfony2', 15), new Tag('php', 3), new Tag('tdd', 4), new Tag('bdd', 5), new Tag('ui', 1), new Tag('phpunit', 3), new Tag('lime', 2)),
                array('symfony' => 'big', 'Symfony2' => 'large', 'php' => 'small', 'tdd' => 'small', 'bdd' => 'small', 'ui' => 'small', 'phpunit' => 'small', 'lime' => 'small')
            ),
            array(
                array('small', 'big', 'large'),
                array(new Tag('symfony', 1), new Tag('Symfony2', 2), new Tag('php', 3), new Tag('tdd', 4), new Tag('bdd', 5), new Tag('ui', 6), new Tag('phpunit', 7), new Tag('lime', 8), new Tag('ddd', 9)),
                array('symfony' => 'small', 'Symfony2' => 'small', 'php' => 'small', 'tdd' => 'small', 'bdd' => 'small', 'ui' => 'small', 'phpunit' => 'big', 'lime' => 'big', 'ddd' => 'large')
            ),
        );
    }

    public function testThatTagsAreWrapped()
    {
        $tagCloud = new TagCloud(array(new Tag('symfony', 2)), array('small', 'big', 'large'));
        $tagCloud->addTag(new Tag('php', 10));

        $tags = $tagCloud->getTags();

        $this->assertContainsOnly('\PSS\Bundle\BlogBundle\TagCloud\TagWrapper', $tags);
    }
}

