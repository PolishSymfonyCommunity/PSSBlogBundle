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

        $query = $entityManager->createQuery(
            'SELECT p, a FROM PSS\Bundle\BlogBundle\Entity\Post p
             INNER JOIN p.author a
             WHERE p.type = \'post\' AND p.status = \'publish\'
             ORDER BY p.publishedAt DESC'
        );
        $query->setMaxResults(3);

        $posts = $query->getResult();

        return $this->render('PSSBlogBundle:Blog:index.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function showAction($slug)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $query = $entityManager->createQuery(
            'SELECT p FROM PSS\Bundle\BlogBundle\Entity\Post p
             WHERE p.slug = :slug
             AND p.status = \'publish\'
             AND p.type IN (\'post\', \'page\')'
        );
        $query->setParameter('slug', $slug);

        try {
            $post = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $exception) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Page Not Found');
        }

        return $this->render('PSSBlogBundle:Blog:show.html.twig', array('post' => $post));
    }
}
