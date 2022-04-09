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

    /**
     * @Route ("/delete/{id}",name="UserDelete")
     */
    public function userDelete($id)
    {
        $repository=$this->getDoctrine()->getRepository(User::class);

        $user=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
    
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_user');
    }
}
