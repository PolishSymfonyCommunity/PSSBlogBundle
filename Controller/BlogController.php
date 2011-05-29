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

        $posts = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
            ->findPublishedPosts();

        return $this->render('PSSBlogBundle:Blog:index.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("/tag/{tag}", name="blog_posts_by_tag")
     */
    public function postsByTagAction($tag)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $posts = $entityManager
            ->getRepository('PSS\Bundle\BlogBundle\Entity\Post')
            ->findPublishedPostsByTag($tag);

        if (!$posts) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Page Not Found');
        }

        return $this->render('PSSBlogBundle:Blog:postsByTag.html.twig', array('posts' => $posts));
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
}
