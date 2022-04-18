<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 */
class UserController extends AbstractController
{
    /**
     *  @Route("/user", name="app_user")
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
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_user');
    }

    /**
     * @Route ("/updateuser/{id}" , name="UserUpdate")
     */
    public function update($id, UserRepository $repository, Request $request)
    {
        $user = $repository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->add('update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/newUser.html.twig', ['UserForm' => $form->createView()]);
    }

    /**
     *  @Route("/newuser", name="newuser")
     */
    public function newUser(Request $request): Response
    {
        $user = new User();
        $user->setPassword("");

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/newUser.html.twig', [
            'UserForm' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/block/{id}" , name="UserBlock")
     */
    public function block($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $user->setIsBlocked(!$user->IsBlocked());

        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('app_user');
    }
}
