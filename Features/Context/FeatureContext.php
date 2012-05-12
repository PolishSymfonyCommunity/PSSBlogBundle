<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\CommonContexts\SymfonyDoctrineContext;

class FeatureContext extends BehatContext
{
    /**
     * @param array $parameters
     *
     * @return null
     */
    public function __construct(array $parameters = array())
    {
        $this->useContext('blog_post', new BlogPostContext());
        $this->useContext('blog_post_list', new BlogPostListContext());
        $this->useContext('doctrine', new SymfonyDoctrineContext());
        $this->useContext('mink', new MinkContext());
        $this->useContext('phabric', new PhabricContext());
        $this->useContext('tag_cloud', new TagCloudContext());
    }

    /**
     * @return \Phabric\Phabric
     */
    public function getPhabric()
    {
        return $this->getSubcontext('phabric')->getPhabric();
    }
}
