<?php

namespace PSS\Bundle\BlogBundle\Tests\ContentExtensionTest;

use PSS\Bundle\BlogBundle\Twig\Extension\ContentExtension;

class ContentExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension = null;

    public function setUp()
    {
        $this->extension = new ContentExtension();
    }

    /**
     * @dataProvider getPostContents
     */
    public function testThatContentIsCutToTheMoreTag($content, $link, $expectedValue)
    {
        $this->assertEquals($expectedValue, $this->extension->cutToMoreTag($content, $link));
    }

    public static function getPostContents()
    {
        return array(
            array(
                '<p>test</p>aśćł<a href="http://github.com/ruflin/Elastica">elastica</a><li>blog text</li><!--more--><p>more text</p>',
                '<a href="#">more link</a>',
                '<p>test</p>aśćł<a href="http://github.com/ruflin/Elastica">elastica</a><li>blog text</li><a href="#">more link</a>'
            ),
            array(
                '<p>test</p>aśćł<a href="http://github.com/ruflin/Elastica">elastica</a><br />
<li>blog text</li><!--more--><p>more text</p>',
                '<a href="#">more link</a>',
                '<p>test</p>aśćł<a href="http://github.com/ruflin/Elastica">elastica</a><br />
<li>blog text</li><a href="#">more link</a>'
            ),
            array(
                '<p>test</p><li>blog text</li><!--more--><p>more text</p>',
                '',
                '<p>test</p><li>blog text</li>'
            ),
            array(
                '<p>test</p><li>blog text</li><p>more text</p>',
                '<a href="#">more link</a>',
                '<p>test</p><li>blog text</li><p>more text</p>'
            ),
            array(
                '<p>test</p><li>blog text</li><!--more--><p>more text</p><!--more-->',
                '<a href="#">more link</a>',
                '<p>test</p><li>blog text</li><a href="#">more link</a>'
            ),
            array(
                '<p>test</p><li>blog text</li><!--more --><p>more text</p>',
                '<a href="#">more link</a>',
                '<p>test</p><li>blog text</li><a href="#">more link</a>'
            ),
            array(
                '<!--more -->',
                '<a href="#">more link</a>',
                '<a href="#">more link</a>'
            )
        );
    }
}
