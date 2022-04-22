<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MaillingController extends AbstractController
{
    /**
     * @Route("/mailling", name="app_mailling")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $tabuser = $repository->findAll();
        
        return $this->render('mailling/index.html.twig', [
            // 'controller_name' => 'MaillingController',
            'tab' => $tabuser,
        ]);
    }
}
