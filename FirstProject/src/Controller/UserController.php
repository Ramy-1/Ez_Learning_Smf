<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    // @IsGranted("ROLE_ADMIN")
    /**
     * @param UserRepository $repository
     * @return Response
     * @Route ({"/","/afficheuser"},name="afficheuser")
     */
    public function afficheuser(UserRepository $repository)
    {
        //$repository=$this->getDoctrine()->getRepository(Classroom::class);
        $tabuser=$repository->findAll();
        return $this->render('user/index.html.twig',[
            'tab'=>$tabuser
        ]); 
    }
}
