<?php

namespace PSS\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function indexAction()
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $query = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
            ->getPublishedPostsQuery();

        $paginator = $this->createPaginator($query);

        return $this->render('PSSBlogBundle:Blog:index.html.twig', array('paginator' => $paginator));
    }

    /**
     * @Route("/tag/{tag}", name="blog_posts_by_tag")
     */
    public function postsByTagAction($tag)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $query = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
            ->getPublishedPostsByTagQuery($tag);

        $paginator = $this->createPaginator($query);

        if ($paginator->getTotalItemCount() == 0) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Page Not Found');
        }

        return $this->render('PSSBlogBundle:Blog:postsByTag.html.twig', array('paginator' => $paginator));
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function showAction($slug)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        try {
            $post = $entityManager
                ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
                ->findPublishedPostOrPage($slug);
        } catch (\Doctrine\ORM\NoResultException $exception) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Page Not Found');
        }

        return $this->render('PSSBlogBundle:Blog:show.html.twig', array('post' => $post));
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
     * @param Doctrine\ORM\Query
     * @return Zend\Paginator\Paginator
     */
    private function createPaginator(\Doctrine\ORM\Query $query)
    {
        $adapter = $this->get('knp_paginator.adapter');
        $adapter->setQuery($query);
        $adapter->setDistinct(true);

        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setCurrentPageNumber($this->get('request')->query->get('page', 1));
        $paginator->setItemCountPerPage(3);
        $paginator->setPageRange(5);

        return $paginator;
    }
}
