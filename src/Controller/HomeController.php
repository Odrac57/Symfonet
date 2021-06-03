<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(
            [],
        [
            'publishedAt' => 'DESC'
        ],
        10);

        $form = $this->createForm(PostType::class, null, [
            'action' => $this->generateUrl('post_publish')
        ]);

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'post_publish_form' => $form->createView() //nécessaire à la création de la vue
        ]);
    }
}
