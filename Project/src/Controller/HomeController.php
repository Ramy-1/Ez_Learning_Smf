<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TestRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/tests", name="app_test_home")
     */
    public function test_home(TestRepository $testRepository): Response
    {
        $tests=$testRepository->findall();
        return $this->render('home/test_student.html.twig', [
            'controller_name' => 'HomeController',
            'tests'=>$tests
        ]);
    }
}
