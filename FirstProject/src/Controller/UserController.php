<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(UserRepository $repository): Response
    {
        // return $this->render('user/index.html.twig', [
        //     'controller_name' => 'UserController',
        // ]);
        $tabuser = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'tab' => $tabuser
        ]);
    }
}
