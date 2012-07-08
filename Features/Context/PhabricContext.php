<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class PhabricContext extends BehatContext implements KernelAwareInterface
{
    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    private $kernel = null;

    /**
     * @var \Phabric\Phabric $phabric
     */
    private $phabric = null;

    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     *
     * @return null
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return \Phabric\Phabric
     */
    public function getPhabric()
    {
        if (is_null($this->phabric)) {
            $this->initializePhabric();
        }

        return $this->phabric;
    }

    /**
     * @return null
     */
    private function initializePhabric()
    {
        $this->phabric = new \Phabric\Phabric($this->createPhabricDataSource());
        $this->addPhabricDataTransformations();
        $this->phabric->createEntitiesFromConfig($this->getPhabricParameters());
    }

    /**
     * @return \Phabric\Datasource\Doctrine
     */
    private function createPhabricDataSource()
    {
        $doctrine = $this->kernel->getContainer()->get('doctrine');
        $connection = $doctrine->getConnection();
        $dataSource = new \Phabric\Datasource\Doctrine($connection, $this->getPhabricParameters());

        return $dataSource;
    }

    /**
     * @return null
     */
    private function addPhabricDataTransformations()
    {
        $this->phabric->addDataTransformation(
            'TEXTTOMYSQLDATE', function($date) {
                $date = \DateTime::createFromFormat('dS M Y', $date);

                return $date->format('Y-m-d H:i:s');
            }
        );
        $this->phabric->addDataTransformation(
            'USERLOOKUP', function($userLogin, $bus) {
                $user = $bus->getEntity('User');

                return $user->getNamedItemId($userLogin);
            }
        );
        $this->phabric->addDataTransformation(
            'TERMLOOKUP', function($term, $bus) {
                $termEntity = $bus->getEntity('Term');

                return $termEntity->getNamedItemId($term);
            }
        );
        $this->phabric->addDataTransformation(
            'POSTLOOKUP', function($title, $bus) {
                $post = $bus->getEntity('Post');

                return $post->getNamedItemId($title);
            }
        );
        $this->phabric->addDataTransformation(
            'TERMTAXONOMYLOOKUP', function($term, $bus) {
                $termEntity = $bus->getEntity('Term');
                $termId = $termEntity->getNamedItemId($term);
                $termTaxonomyEntity = $bus->getEntity('TermTaxonomy');

                return $termTaxonomyEntity->getNamedItemId($termId);
            }
        );
    }

    /**
     * @return array
     */
    private function getPhabricParameters()
    {
        return array(
            'User' => array(
                'tableName' => 'wp_users',
                'primaryKey' => 'ID',
                'nameCol' => 'user_login',
                'nameTransformations' => array(
                    'Display name' => 'display_name',
                    'Login' => 'user_login',
                    'Password' => 'user_pass',
                    'E-mail' => 'user_email',
                    'URL' => 'user_url'
                )
            ),
            'Post' => array(
                'tableName' => 'wp_posts',
                'primaryKey' => 'ID',
                'nameCol' => 'post_title',
                'nameTransformations' => array(
                    'Title' => 'post_title',
                    'Type' => 'post_type',
                    'Status' => 'post_status',
                    'Published at' => 'post_date',
                    'Author' => 'post_author',
                    'Excerpt' => 'post_excerpt',
                    'Content' => 'post_content',
                    'Slug' => 'post_name'
                ),
                'dataTransformations' => array(
                    'post_date' => 'TEXTTOMYSQLDATE',
                    'post_author' => 'USERLOOKUP'
                )
            ),
            'TermRelationship' => array(
                'tableName' => 'wp_term_relationships',
                'primaryKey' => array('object_id', 'term_taxonomy_id'),
                'nameCol' => 'term_order', // dirty hack for phabric
                'nameTransformations' => array(
                    'Post' => 'object_id',
                    'Term' => 'term_taxonomy_id',
                    'Order' => 'term_order'
                ),
                'dataTransformations' => array(
                    'object_id' => 'POSTLOOKUP',
                    'term_taxonomy_id' => 'TERMTAXONOMYLOOKUP'
                )
            ),
            'TermTaxonomy' => array(
                'tableName' => 'wp_term_taxonomy',
                'primaryKey' => 'term_taxonomy_id',
                'nameCol' => 'term_id', // phabric forces us to give a nameCol, this limits us to one taxonomy per term
                'nameTransformations' => array(
                    'Taxonomy' => 'taxonomy',
                    'Term' => 'term_id'
                ),
                'dataTransformations' => array(
                    'term_id' => 'TERMLOOKUP'
                )
            ),
            'Term' => array(
                'tableName' => 'wp_terms',
                'primaryKey' => 'term_id',
                'nameCol' => 'name',
                'nameTransformations' => array(
                    'Name' => 'name',
                    'Slug' => 'slug'
                ),
                'dataTransformations' => array(
                    'post_date' => 'TEXTTOMYSQLDATE',
                    'post_author' => 'USERLOOKUP'
                )
            )
        );
    }
}
