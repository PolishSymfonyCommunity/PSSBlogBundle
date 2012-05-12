<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\Behat\Context\Step\Then;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;

class BlogPostListContext extends RawMinkContext
{
    /**
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^(?:|the )following users are blog authors$/
     *
     * @return null
     */
    public function followingUsersAreBlogAuthors(TableNode $table)
    {
        $this->getPhabric()->insertFromTable('User', $table);
    }

    /**
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^(?:|the )following blog posts are written$/
     *
     * @return null
     */
    public function theFollowingBlogPostsAreWritten(TableNode $table)
    {
        $this->getPhabric()->insertFromTable('Post', $table);
    }

    /**
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^(?:|the )blog posts are tagged with (?:|the )following terms$/
     *
     * @return null
     */
    public function theFollowingBlogPostsAreTaggedWithTheFollowingTerms(TableNode $table)
    {
        return new Then('the following blog posts are in "post_tag" relation with the following terms', $table);
    }

    /**
     * @param string                        $relationType
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^(?:|the )following blog posts are in (?:|a )"(?P<relationType>category|post_tag)" relation with (?:|the )following terms$/
     *
     * @return null
     */
    public function theFollowingBlogPostsAreInRelationWithTheFollowingTerms($relationType, TableNode $table)
    {
        static $id = 1;

        $relationTypeMappings = array('category' => 'Categories', 'post_tag' => 'Tags');
        $termsField = $relationTypeMappings[$relationType];

        $termsTable = new TableNode('|Name|Slug|');
        $termTaxonomiesTable = new TableNode('|Term|Taxonomy|Count|');
        $termRelationshipsTable = new TableNode('|Post|Term|Order|');

        $terms = array();
        $termTaxonomies = array();
        foreach ($table->getHash() as $row) {
            $postTerms = explode(',', $row[$termsField]);
            foreach ($postTerms as $term) {
                $term = trim($term);
                $terms[$term] = array($term, $term);

                if (!isset($termTaxonomies[$term])) {
                    $termTaxonomies[$term] = array($term, $relationType, 1);
                } else {
                    $termTaxonomies[$term][2]++;
                }

                $termRelationshipsTable->addRow(array($row['Title'], $term, $id++));
            }
        }

        foreach ($terms as $term) {
            $termsTable->addRow($term);
        }

        foreach ($termTaxonomies as $termTaxonomy) {
            $termTaxonomiesTable->addRow($termTaxonomy);
        }

        $this->getPhabric()->insertFromTable('Term', $termsTable);
        $this->getPhabric()->insertFromTable('TermTaxonomy', $termTaxonomiesTable);
        $this->getPhabric()->insertFromTable('TermRelationship', $termRelationshipsTable);
    }

    /**
     * @When /^(?:|I )visit (?:|the )list of blog posts page$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iVisitTheBlogPostList()
    {
        return new Then('I go to "/blog"');
    }

    /**
     * @param string $slug
     *
     * @When /^(?:|I )visit (?:|the )list of blog posts tagged with "(?P<slug>[^"]*)" page$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iVisitTheListOfBlogPostsTaggedWithPage($slug)
    {
        $url = '/tag/'.$slug;

        return new Then(sprintf('I go to "%s"', $url));
    }

    /**
     * @param string $title
     *
     * @Then /^(?:|I )should see "(?P<title>([^"]*))" title on the blog post list$/
     *
     * @return null
     */
    public function iShouldSeeTitleOnTheBlogPostList($title)
    {
        $node = $this->getSession()->getPage()->find('xpath', sprintf('//h2[contains(., "%s")]', $title));

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Blog post title');
        }
    }

    /**
     * @param string $title
     *
     * @Given /^(?:|I )should not see "(?P<title>([^"]*))" title on the blog post list$/
     *
     * @return null
     */
    public function iShouldNotSeeTitleOnTheBlogPostList($title)
    {
        $node = $this->getSession()->getPage()->find('xpath', sprintf('//h2[contains(., "%s")]', $title));

        if (!is_null($node)) {
            throw new ExpectationException(sprintf('Blog post "%s" found but not expected', $title), $this->getSession());
        }
    }

    /**
     * @param string $title
     * @param string $date
     * @param string $author
     *
     * @Then /^(?:|I )should see that (?:|the )"(?P<title>([^"]*))" blog post was written on "(?P<date>([^"]*))" by "(?P<author>([^"]*))"$/
     *
     * @return null
     */
    public function iShouldSeeThatTheBlogPostWasWrittenOnBy($title, $date, $author)
    {
        $xpath = sprintf('//h2[contains(., "%s")]/following-sibling::div[@class="post-meta"]', $title);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Post meta');
        }

        $meta = $node->getText();

        if (false === strpos($meta, date('d M Y', strtotime($date)))) {
            throw new ExpectationException(sprintf('Publishing date for "%s" was not found in meta details: "%s"', $title, $meta), $this->getSession());
        }

        if (false === strpos($meta, $author)) {
            throw new ExpectationException(sprintf('Publishing date for "%s" was not found in meta details', $title, $meta), $this->getSession());
        }
    }

    /**
     * @param string $title
     *
     * @Then /^(?:|I )should see (?:|an )excerpt of (?:|the )"(?P<title>([^"]*))" blog post on the list$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iShouldSeeAnExcerptOfBlogPost($title)
    {
        $post = $this->findPostByTitle($title);
        $excerpt = str_replace('"', '\\"', $post['post_excerpt']);

        return new Then(sprintf('I should see "%s" as an excerpt of the "%s" blog post', $excerpt, $title));
    }

    /**
     * @param string $title
     *
     * @Given /^(?:|I )should see (?:|a )full content of (?:|the )"(?P<title>([^"]*))" blog post on the list$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iShouldSeeAFullContentOfBlogPost($title)
    {
        $post = $this->findPostByTitle($title);
        $excerpt = str_replace('"', '\\"', $post['post_content']);

        return new Then(sprintf('I should see "%s" as an excerpt of the "%s" blog post', $excerpt, $title));
    }

    /**
     * @param string $title
     *
     * @Given /^(?:|I )should see (?:|an )introduction of (?:|the )"(?P<title>([^"]*))" blog post on the list$/
     *
     * @return array
     */
    public function iShouldSeeAnIntroductionOfBlogPost($title)
    {
        $post = $this->findPostByTitle($title);
        $excerpt = str_replace('"', '\\"', $post['post_content']);
        $excerptBeforeMore = substr($excerpt, 0, strpos($excerpt, '<!--more-->'));
        $excerptAfterMore = substr($excerpt, strpos($excerpt, '<!--more-->'));

        return array(
            new Then(sprintf('I should see "%s" as an excerpt of the "%s" blog post', $excerptBeforeMore, $title)),
            new Then(sprintf('I should not see "%s" as an excerpt of the "%s" blog post', $excerptAfterMore, $title))
        );
    }

    /**
     * @param string $title
     * @param string $excerpt
     *
     * @Given /^(?:|I )should see "(?P<excerpt>(?:[^"]|\\")*)" as (?:|an )excerpt of (?:|the )"(?P<title>([^"]*))" blog post$/
     *
     * @return null
     */
    public function iShouldSeeAsAnExcerptOfBlogPost($title, $excerpt)
    {
        $excerpt = str_replace('\\"', '"', $excerpt);
        $xpath = sprintf('//h2[contains(., "%s")]/following-sibling::p', $title);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Post excerpt');
        }

        if (false === strpos($node->getHtml(), $excerpt)) {
            throw new ExpectationException(sprintf('Found excerpt: "%s" but expected: "%s"', $node->getHtml(), $excerpt), $this->getSession());
        }
    }

    /**
     * @param string $title
     * @param string $excerpt
     *
     * @Given /^(?:|I )should not see "(?P<excerpt>(?:[^"]|\\")*)" as (?:|an )excerpt of (?:|the )"(?P<title>([^"]*))" blog post$/
     *
     * @return null
     */
    public function iShouldNotSeeAsAnExcerptOfBlogPost($title, $excerpt)
    {
        $excerpt = str_replace('\\"', '"', $excerpt);
        $xpath = sprintf('//h2[contains(., "%s")]/following-sibling::p', $title);
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (is_null($node)) {
            throw new ElementNotFoundException($this->getSession(), 'Post excerpt');
        }

        if (false !== strpos($node->getHtml(), $excerpt)) {
            throw new ExpectationException(sprintf('Found not expected excerpt: "%s"', $excerpt), $this->getSession());
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
