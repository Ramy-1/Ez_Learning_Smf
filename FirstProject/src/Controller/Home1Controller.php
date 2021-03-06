<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home1Controller extends AbstractController
{
    /**
     * @Route("/home1", name="app_home1")
     */
    public function index(): Response
    {
        return $this->render('home1/index.html.twig', [
            'controller_name' => 'Home1Controller',
        ]);
    }
}
