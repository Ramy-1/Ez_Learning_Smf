<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Form\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     *  @Route("/", name="app_user")
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
     * @Route ("/update/{id}" , name="UserUpdate")
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
    /**
     * @Route ("/email" , name="UserEmail")
     */
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $form = $this->createForm(EmailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->get('users')->getData();
            $subject = $form->get('subject')->getData();
            $body = $form->get('body')->getData();

            $email = (new Email())
                ->from('mouhamedrami.bendhia@esprit.tn')
                ->to($user->getEmail())
                // ->to('hana.mensia@esprit.tn')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                ->text('Sending emails is fun again!')
                ->html($body);
            $mailer->send($email);
            return $this->redirectToRoute('app_user');
        }

        $tabuser = $repository->findAll();
        // return $this->redirectToRoute('app_user');
        return $this->render('mailling/index.html.twig', [
            'form' => $form->createView(),
            'tab' => $tabuser,

        ]);
    }
}
