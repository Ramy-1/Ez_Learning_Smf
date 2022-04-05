<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\User;
use App\Form\RegistrationFormType;
// use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


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
        $tabuser = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'tab' => $tabuser
        ]);
    }
    // public function signup($id,UserRepository $repository ,Request $request)
    // {
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        // AppCustomAuthenticator $authenticator,
        EntityManagerInterface $entityManager
        // Swift_Mailer $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // encode the plain password
            // $user->setPassword(
            //     $userPasswordEncoder->encodePassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );
            // generer un activation token
            // $user->setActivationToken(md5(uniqid()));

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            // $message = (new \Swift_Message('Activation de votre compte'))
            //     ->setFrom('infernalgames200@gmail.com')
            //     ->setTo($user->getEmail())
            //     ->setBody(
            //         $this->renderView(
            //             'emails/activation.html.twig',
            //             ['token' => $user->getActivationToken()]
            //         ),
            //         'text/html'
            //     );
            // $mailer->send($message);
            return $this->redirectToRoute('afficheuser');
        }

        return $this->render('user/newUser.html.twig', [
            'UserForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idUser}", name="UserDelete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('afficheuser', [], Response::HTTP_SEE_OTHER);

    }

    // @IsGranted("ROLE_ADMIN")
    /**
     * @Route ("/delete/{id}",name="UserDeletee")
     */
    public function deletee($id)
    {
        $repository=$this->getDoctrine()->getRepository(User::class);
        // $rep=$this->getDoctrine()->getRepository(Panier::class);

        $user=$repository->find($id);
        // $panier=$rep->findOneBy(['user'=>$user]);
        $em=$this->getDoctrine()->getManager();
        // $em->remove($panier);
        // $em->flush();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('afficheuser');
    }

    /**
     * @Route ("/updateuser/{id}" , name="UserUpdate")
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
        return $this->render('user/newUser.html.twig',['UserForm'=>$form->createView()]);
    }
}
