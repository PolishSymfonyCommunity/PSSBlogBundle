<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\Behat\Context\Step\Then;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;

class TagCloudContext extends RawMinkContext
{
    /**
     * @param string $term
     * @param string $count
     *
     * @Given /^there are "(?P<count>\d+)" blog posts tagged with "(?P<term>[^"]*)"$/
     *
     * @return array
     */
    public function thereAreBlogPostsTaggedWith($term, $count)
    {
        $blogPostTable = new TableNode('|Title|Type|Status|Published at|Excerpt|Content|Slug|');
        $tagTable = new TableNode('|Title|Tags|');
        for ($i = 1; $i <= $count; $i++) {
            $title = 'Post '.$i;
            $blogPostTable->addRow(array($title, 'post', 'published', '7th May 2011', 'Post excerpt '.$i, 'Post content '.$i, 'post-'.$i));
            $tagTable->addRow(array($title, $term));
        }

        return array(
            new Then('the following blog posts are written', $blogPostTable),
            new Then('the blog posts are tagged with the following terms', $tagTable)
        );
    }

    /**
     * @param string $term
     *
     * @Given /^there are "(?P<count>\d+)" blog posts in (?:|the )"(?P<term>[^"]*)" category$/
     *
     * @return array
     */
    public function thereAreBlogPostsInThe($term, $count)
    {
        $blogPostTable = new TableNode('|Title|Type|Status|Published at|Excerpt|Content|Slug|');
        $categoryTable = new TableNode('|Title|Categories|');
        for ($i = 1; $i <= $count; $i++) {
            $title = 'Post '.$i;
            $blogPostTable->addRow(array($title, 'post', 'published', '7th May 2011', 'Post excerpt '.$i, 'Post content '.$i, 'post-'.$i));
            $categoryTable->addRow(array($title, $term));
        }

        return array(
            new Then('the following blog posts are written', $blogPostTable),
            new Then('the blog posts belong to the following categories', $categoryTable)
        );
    }

    /**
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^(?:|the )blog posts belong to (?:|the )following categories$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function theFollowingBlogPostsBelongToTheFollowingCategories(TableNode $table)
    {
        return new Then('the following blog posts are in "category" relation with the following terms', $table);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )tag cloud$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iShouldSeeATagCloud()
    {
        return new Then('I should see an "ul.tag-cloud" element');
    }

    /**
     * @param string $term
     * @param string $count
     *
     * @Given /^(?:|I )should see on (?:|the )tag cloud that there are "(?P<count>\d+)" blog posts tagged with "(?P<term>[^"]*)"$/
     *
     * @return null
     */
    public function iShouldSeeOnTheTagCloudThatThereAreBlogPostsTaggedWith($term, $count)
    {
        $xpath = sprintf('//ul[contains(@class, "tag-cloud")]//li/a[contains(., "%s")]', $term);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Tag');
        }

        $tagTitle = $node->getAttribute('title');
        $title = sprintf('%d posts tagged with %s', $count, $term);

        if ($title != $tagTitle) {
            throw new ExpectationException(sprintf('Expected "%s" but found: "%s"', $title, $tagTitle), $this->getSession());
        }
    }

    /**
     * @param string $term
     *
     * @Given /^(?:|I )should see on (?:|the )tag cloud that there is no blog posts tagged with "(?P<term>[^"]*)"$/
     *
     * @return null
     */
    public function iShouldSeeOnTheTagCloudThatThereIsNoBlogPostsTaggedWith($term)
    {
        $xpath = sprintf('//ul[contains(@class, "tag-cloud")]//li/a[contains(., "%s")]', $term);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (!is_null($node)) {
            throw new ExpectationException(sprintf('Tag "%s" was not expected on the tag cloud', $term), $this->getSession());
        }
    }

    /**
     * @return \Phabric\Phabric
     */
    private function getPhabric()
    {
        return $this->getMainContext()->getPhabric();
    }
}
