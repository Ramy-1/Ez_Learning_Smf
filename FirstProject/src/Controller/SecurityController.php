<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/SignUp", name="app_signup")
     */
    // public function SignUp(Request $request): Response
    // {

    //     $user = new User();

    //     $form = $this->createForm(TaskType::class, $user);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // $form->getData() holds the submitted values
    //         // but, the original `$task` variable has also been updated
    //         $user = $form->getData();

    //         // ... perform some action, such as saving the task to the database
    //         $user->setPassword(
    //             $userPasswordEncoder->encodePassword(
    //                     $user,
    //                     $form->get('plainPassword')->getData()
    //                 )
    //             );

    //         return $this->redirectToRoute('task_success');
    //     }

    // }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
