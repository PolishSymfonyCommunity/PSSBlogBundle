<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\Behat\Context\Step\Then;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;

class BlogPostContext extends RawMinkContext
{
    /**
     * @param string $title
     *
     * @Given /^(?:|I )click (?:|the )"(?P<title>[^"]*)" title on (?:|the )blog post list$/
     *
     * @return null
     */
    public function iClickTheTitleOnTheBlogPostList($title)
    {
        $node = $this->getSession()->getPage()->find('xpath', sprintf('//h2[contains(., "%s")]/a', $title));

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Blog post title');
        }

        $node->click();
    }

    /**
     * @param string $title
     *
     * @When /^(?:|I )visit (?:|the )"(?P<title>[^"]*)" blog post page$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iVisitTheBlogPostPage($title)
    {
        $post = $this->findPostByTitle($title);
        $url = '/'.$post['post_name'];

        return new Then(sprintf('I go to "%s"', $url));
    }

    /**
     * @param string $title
     *
     * @Given /^(?:|I )should see (?:|the )"(?P<title>[^"]*)" blog post$/
     *
     * @return null
     */
    public function iShouldSeeAFullContentOfTheBlogPost($title)
    {
        $xpath = sprintf('//h1[contains(., "%s")]/following-sibling::p', $title);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Blog post', 'xpath', $xpath);
        }

        $post = $this->findPostByTitle($title);
        $content = $post['post_content'];
        if (false === strpos($node->getHtml(), $content)) {
            throw new ExpectationException(sprintf('Found blog post content: "%s" but expected: "%s"', $node->getHtml(), $content), $this->getSession());
        }
    }

    /**
     * @param string $title
     *
     * @return array
     */
    private function findPostByTitle($title)
    {
        $postEntity = $this->getPhabric()->getEntity('Post');
        $post = $postEntity->getNamedItem($title);

        if (!$post) {
            throw new \LogicException(sprintf('Could not find a blog post of given title: "%s"', $title));
        }

        return $post;
    }

    /**
     * @return \Phabric\Phabric
     */
    private function getPhabric()
    {
        return $this->getMainContext()->getPhabric();
    }
}
