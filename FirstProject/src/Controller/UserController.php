<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

    /**
     * @Route ("/updateuser/{id}" , name="updateuser")
     */
    public function update($id,UserRepository $repository ,Request $request)
    {
        $user=$repository->find($id);
        $form=$this->createForm(UserType::class, $user);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheuser');
        }
        return $this->render('user/newUser.html.twig',['form'=>$form->createView()]);
    }
}
