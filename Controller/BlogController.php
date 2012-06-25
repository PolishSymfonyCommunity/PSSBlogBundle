<?php

namespace PSS\Bundle\BlogBundle\Controller;


# Symfony/Doctrine internal
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


# Specific


# Domain objects


# Entities
use PSS\Bundle\BlogBundle\Entity\Post;
use PSS\Bundle\BlogBundle\Entity\Term;



/**
 * Base Controller
 *
 * Basic views available here, to override you can 
 * use the PostManager service. The idea of this controller
 * is that you can extend as a Base, and alter the returned array()
 * that each method returns using parent::methodName();
 *
 * Cookbook in PSSBlogBundle/Resources/doc/recipe-extending-blog-controller.md
 * 
 * @Route("/blog")
 */
class BlogController extends Controller
{




    /**
     * @Route("/{year}/{month}/{slug}", name="blog_show")
     * @Template()
     */
    public function showAction(Post $post)
    {
        return array(
            'post' => $post->onlyIfPublished()
        );
    }


    /**
     * @Route("/", name="blog_index")
     * @Template()
     */
    public function indexAction()
    {
        $pm = $this->getPostManager();
        $paginator = $this->createPaginator($pm->getRepository()->getPublishedPostsQuery());

        return array(
            'paginator' => $paginator
        );
    }


    /**
     * @Route("/tag/{slug}", name="blog_posts_by_tag")
     * @Template()
     */
    public function postsByTagAction(Term $term)
    {
        $pm = $this->getPostManager();
        $repository = $pm->getRepository();
        $query = $repository
                        ->getPublishedByTerm($term);

        $paginator = $this->createPaginator($query->getQuery());

        if ($paginator->getTotalItemCount() == 0) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Page Not Found');
        }

        return array(
            'paginator' => $paginator
        );
    }


    public function recentPostsAction($max)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $posts = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
            ->findPublishedPosts($max);

        return $this->render('PSSBlogBundle:Blog:recentPosts.html.twig', array('posts' => $posts));
    }

    public function tagCloudAction()
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $tags = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Term')
            ->findAllTags();

        $tagCloud = new \PSS\Bundle\BlogBundle\TagCloud\TagCloud($tags, array('size1', 'size2', 'size3', 'size4', 'size5', 'size6', 'size7', 'size8'));

        return $this->render('PSSBlogBundle:Blog:tagCloud.html.twig', array('tagCloud' => $tagCloud));
    }



    /**
     * Access to Post Manager service
     * 
     * @return \PSS\Bundle\BlogBundle\Manager\PostManager
     */
    protected function getPostManager()
    {
        return $this->get('pss.blog.manager.post');
    }



    /**
     * Create a paginator from a Query
     *
     * @param \Doctrine\ORM\Query $query
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    protected function createPaginator(\Doctrine\ORM\Query $query)
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->get('request');
        $page = $request->query->get('page', 1);

        return $paginator->paginate($query, $page, 3);
    }
}
