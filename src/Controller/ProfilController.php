<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/user/{id}", name="user_profil")
     */
    public function index(int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('profil/user.html.twig', [
            'user' => $user,
        ]);
    }
}
