<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\BehatBundle\Context\MinkContext;
use Behat\Gherkin\Node\TableNode;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @see PSS\Bundle\BlogBundle\Entity\User
     * @var array $users
     */
    public $users = array();

    /**
     * @see PSS\Bundle\BlogBundle\Entity\Post
     * @var array $posts
     */
    public $posts = array();

    /**
     * @see PSS\Bundle\BlogBundle\Entity\Term
     * @var array $terms
     */
    public $terms = array();

    /**
     * @see PSS\Bundle\BlogBundle\Entity\TermTaxonomy
     * @var array $taxonomies
     */
    public $taxonomies = array('post_tag' => array(), 'category' => array());

    /**
     * @param AppKernel $kernel
     * @return null
     */
    public function __construct($kernel)
    {
        parent::__construct($kernel);

        $this->cleanDatabase();
    }

    /**
     * @return null
     */
    private function cleanDatabase()
    {
        $container = $this->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\TermRelationship')->execute();
        $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\TermTaxonomy')->execute();
        $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\Post')->execute();
        $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\Term')->execute();
        $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\User')->execute();
    }

    /**
     * @Given /^site has users:$/
     */
    public function siteHasUsers(TableNode $table)
    {
        $container = $this->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        foreach ($table->getHash() as $row) {
            $user = new \PSS\Bundle\BlogBundle\Entity\User();

            $this->setPrivateProperty($user, 'login', $row['login']);
            $this->setPrivateProperty($user, 'password', $row['password']);
            $this->setPrivateProperty($user, 'niceName', $row['login']);
            $this->setPrivateProperty($user, 'email', $row['email']);
            $this->setPrivateProperty($user, 'url', $row['url']);
            $this->setPrivateProperty($user, 'registeredAt', new \DateTime('now'));
            $this->setPrivateProperty($user, 'activationKey', 'key121212');
            $this->setPrivateProperty($user, 'status', 0);
            $this->setPrivateProperty($user, 'displayName', $row['display_name']);

            $entityManager->persist($user);

            $this->users[$row['login']] = $user;
        }

        $entityManager->flush();
    }

    /**
     * @Given /^site has blog posts:$/
     */
    public function siteHasBlogPosts(TableNode $table)
    {
        $container = $this->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        foreach ($table->getHash() as $row) {
            $post = new \PSS\Bundle\BlogBundle\Entity\Post();
            $user = $this->users[$row['user_login']];

            $this->setPrivateProperty($post, 'title', $row['title']);
            $this->setPrivateProperty($post, 'slug', $row['slug']);
            $this->setPrivateProperty($post, 'type', $row['type']);
            $this->setPrivateProperty($post, 'status', $row['status']);
            $this->setPrivateProperty($post, 'publishedAt', new \DateTime($row['published_at']));
            $this->setPrivateProperty($post, 'publishedAtAsGmt', new \DateTime($row['published_at']));
            $this->setPrivateProperty($post, 'modifiedAt', new \DateTime($row['published_at']));
            $this->setPrivateProperty($post, 'modifiedAtAsGmt', new \DateTime($row['published_at']));
            $this->setPrivateProperty($post, 'excerpt', $row['excerpt']);
            $this->setPrivateProperty($post, 'content', $row['content']);
            $this->setPrivateProperty($post, 'author', $user);
            $this->setPrivateProperty($post, 'commentStatus', '');
            $this->setPrivateProperty($post, 'pingStatus', '');
            $this->setPrivateProperty($post, 'password', '');
            $this->setPrivateProperty($post, 'toPing', '');
            $this->setPrivateProperty($post, 'pinged', '');
            $this->setPrivateProperty($post, 'contentFiltered', '');
            $this->setPrivateProperty($post, 'parentId', 0);
            $this->setPrivateProperty($post, 'guid', '');
            $this->setPrivateProperty($post, 'menuOrder', '');
            $this->setPrivateProperty($post, 'mimeType', '');
            $this->setPrivateProperty($post, 'commentCount', '');

            $entityManager->persist($post);
            $entityManager->flush();

            $this->posts[$row['title']] = $post;

            if (isset($row['tags'])) {
                $this->theBlogPostIsTaggedWithKeywords($row['title'], $row['tags']);
            }

            if (isset($row['categories'])) {
                $this->theBlogPostBelongsToCategories($row['title'], $row['categories']);
            }
        }
    }

    /**
     * @Given /^the blog post "(.*?)" is tagged with "(.*?)" keywords$/
     */
    public function theBlogPostIsTaggedWithKeywords($postTitle, $tags)
    {
        $tags = explode(',', trim($tags));

        if (!empty($tags)) {
            foreach ($tags as $tagName) {
                $this->theBlogPostIsTaggedWithKeyword($postTitle, $tagName);
            }
        }
    }

    /**
     * @Given /^the blog post "(.*?)" belongs to "(.*?)" categories$/
     */
    public function theBlogPostBelongsToCategories($postTitle, $categories)
    {
        $categories = explode(',', trim($categories));

        if (!empty($categories)) {
            foreach ($categories as $categoryName) {
                $this->theBlogPostBelongsToCategory($postTitle, $categoryName);
            }
        }
    }

    /**
     * @Given /^the blog post "(.*?)" is tagged with "(.*?)" keyword$/
     */
    public function theBlogPostIsTaggedWithKeyword($postTitle, $tagName)
    {
        $this->theBlogPostIsLabeledWith($postTitle, $tagName, 'post_tag');
    }

    /**
     * @Given /^the blog post "(.*?)" belongs to "(.*?)" category$/
     */
    public function theBlogPostBelongsToCategory($postTitle, $categoryName)
    {
        $this->theBlogPostIsLabeledWith($postTitle, $categoryName, 'category');
    }

    /**
     * @Given /^the blog post "(.*?)" is labeled with "(.*?)" (.*?)$/
     */
    public function theBlogPostIsLabeledWith($postTitle, $termName, $taxonomyName)
    {
        $this->siteHasTerm($termName, $taxonomyName);

        $taxonomy = $this->taxonomies[$taxonomyName][$termName];
        $post = $this->posts[$postTitle];
        $relation = new \PSS\Bundle\BlogBundle\Entity\TermRelationship();
        $postCount = $this->getPrivateProperty($taxonomy, 'count');

        $this->setPrivateProperty($relation, 'post', $post);
        $this->setPrivateProperty($relation, 'objectId', $this->getPrivateProperty($post, 'id'));
        $this->setPrivateProperty($relation, 'termTaxonomy', $taxonomy);
        $this->setPrivateProperty($relation, 'termTaxonomyId', $this->getPrivateProperty($taxonomy, 'id'));
        $this->setPrivateProperty($relation, 'termOrder', '1');

        if ('publish' == $this->getPrivateProperty($post, 'status')) {
            $this->setPrivateProperty($taxonomy, 'count', ++$postCount);
        }

        $container = $this->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $entityManager->persist($taxonomy);
        $entityManager->persist($relation);
        $entityManager->flush();
    }

    /**
     * @Given /^site has tags:$/
     */
    public function siteHasTags(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->siteHasTag($row['tag']);
        }
    }

    /**
     * @Given /^site has categories:$/
     */
    public function siteHasCategories(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->siteHasCategory($row['tag']);
        }
    }

    /**
     * @Given /^site has an? "(.*?)" tag$/
     */
    public function siteHasTag($tagName)
    {
        $this->siteHasTerm($tagName, 'post_tag');
    }

    /**
     * @Given /^site has an? "(.*?)" category$/
     */
    public function siteHasCategory($categoryName)
    {
        $this->siteHasTerm($categoryName, 'category');
    }

    /**
     * @Given /^site has "(.*?)" term which is a "(.*?)" taxonomy$/
     */
    public function siteHasTerm($termName, $taxonomyName)
    {
        $container = $this->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        if (!isset($this->terms[$termName])) {
            $term = new \PSS\Bundle\BlogBundle\Entity\Term();

            $this->setPrivateProperty($term, 'name', $termName);
            $this->setPrivateProperty($term, 'slug', $termName);
            $this->setPrivateProperty($term, 'group', 0);

            $entityManager->persist($term);

            $this->terms[$termName] = $term;
        }

        if (!isset($this->taxonomies[$taxonomyName][$termName])) {
            $term = $this->terms[$termName];
            $taxonomy = new \PSS\Bundle\BlogBundle\Entity\TermTaxonomy();

            $this->setPrivateProperty($taxonomy, 'taxonomy', $taxonomyName);
            $this->setPrivateProperty($taxonomy, 'description', '');
            $this->setPrivateProperty($taxonomy, 'parentId', 0);
            $this->setPrivateProperty($taxonomy, 'count', 0);
            $this->setPrivateProperty($taxonomy, 'term', $term);

            $entityManager->persist($taxonomy);

            $this->taxonomies[$taxonomyName][$termName] = $taxonomy;
        }

        $entityManager->flush();
    }

    /**
     * We don't want to add setters just because we need them in tests.
     * Also, we want to set raw data. This copies the way Doctrine's loading
     * fixtures.
     *
     * @param mixed $object
     * @param string $propertyName
     * @param mixed $value
     * @return null
     */
    private function setPrivateProperty($object, $propertyName, $value)
    {
        $reflection = new \ReflectionObject($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * @param mixed $object
     * @param string $propertyName
     * @return mixed
     */
    private function getPrivateProperty($object, $propertyName)
    {
        $reflection = new \ReflectionObject($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
