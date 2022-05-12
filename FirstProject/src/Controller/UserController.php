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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
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

        $tabuser = $repository->findAll();
        // $o = new User();
        
        $stats[] = new Stat();
        
        $tabStat = [0, 0, 0, 0, 0, 0];
        $names = ['','','','','','',];

        $names[0]=('ADMIN');
        $names[1]=('ETUDIANT');
        $names[2]=('RECRUTEUR');
        $names[3]=('ENSIEGNAN');
        $names[4]=('UNIVERSITE');
        $names[5]=('User');

        foreach ($tabuser as $o) {
            if (in_array('ROLE_ADMIN', $o->getRoles())) {
                $tabStat[0]++;
            }
            if (in_array('ROLE_ETUDIANT', $o->getRoles())) {
                $tabStat[1]++;
            }
            if (in_array('ROLE_RECRUTEUR', $o->getRoles())) {
                $tabStat[2]++;
            }
            if (in_array('ROLE_ENSIEGNANT', $o->getRoles())) {
                $tabStat[3]++;
            }
            if (in_array('ROLE_UNIVERSITE', $o->getRoles())) {
                $tabStat[4]++;
            }
            if (in_array('ROLE_User', $o->getRoles())) {
                $tabStat[5]++;
            }
        }
        // foreach ($stats as $stat){
        //     $stat->setNum(tabStat);
        // }
        return $this->render('user/index.html.twig', [
            'tab' => $tabuser,
            'size' => sizeof($tabuser),
            'tabStat' => $tabStat,
            'names' => $names
        ]);
    }


    /**
     * @Route("/listUserJSON", name="listUserJSON")
     */
    public function listUserJSON(NormalizerInterface $Normalizer)
    {
        $donnees = $this->getDoctrine()->getRepository(User::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($donnees);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/addUserJSON",name="addUserJSON")
     */

    public function ajouterUserJSON(Request $request, NormalizerInterface $Normalizer, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setId($request->get('id'));
        $user->setName($request->get('name'));
        $user->setLastName($request->get('lastName'));
        $user->setEmail($request->get('email'));
        
        $user->setPassword(
            $userPasswordEncoder->encodePassword(
                $user,
                $request->get('password')
            )
        );
        $em->persist($user);
        $em->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));;
    }

    /**
     * @Route("/deleteUserJSON", name="deleteUserJSON")
     */
    public function deleteUserJSON(Request $request)

    {
        $iduser = $request->get("iduser");
        $em = $this->getDoctrine()->getManager();
        $User = $em->getRepository(User::class)->find($iduser);
        if ($User != null) {
            $em->remove($User);
            $em->flush();
            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("User supprimee avec succes");
            return new JsonResponse($formatted);
        }

        return new JsonResponse("iduser invalide");
    }

    /**
     * @Route("/updateUserJSON", name="updateUserJSON")
     */
    public function updateUserJSON(Request $request)

    {
        $iduser = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($iduser);
        $user->setId($iduser);
        $user->setName($request->get('name'));
        $user->setLastName($request->get('lastName'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $em->persist($user);
        $em->flush();
        $serialize = new Serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize("User modifiee avec succes");
        return new JsonResponse($formatted);
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
     *  @Route("/new", name="newuser")
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

            $email = (new TemplatedEmail())
                ->from('mouhamedrami.bendhia@esprit.tn')
                ->to($user->getEmail())
                // ->to('hana.mensia@esprit.tn')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                // ->text('Sending emails is fun again!')
                ->html($body)
                // ->context([
                //     'Description' => 'foo',
                // ])
            ;

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
    /**
     * @Route ("/emailall" , name="UserEmailtoALL")
     */
    public function sendEmailToAll(MailerInterface $mailer, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $tab = $repository->findAll();


        $form = $this->createForm(EmailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $user = $form->get('users')->getData();
            // $subject = $form->get('subject')->getData();
            $body = $form->get('body')->getData();
            foreach ($tab as $user) {
                $email = (new TemplatedEmail())
                    ->from('mouhamedrami.bendhia@esprit.tn')
                    ->to($user->getEmail())
                    // ->to('hana.mensia@esprit.tn')
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject("Email From Ez-learning")
                    // ->text('Sending emails is fun again!')
                    ->html($body)
                    // ->context([
                    //     'Description' => 'foo',
                    // ])
                ;
                $mailer->send($email);
            }
            return $this->redirectToRoute('app_user');
        }

        $tabuser = $repository->findAll();
        // return $this->redirectToRoute('app_user');
        return $this->render('mailling/notif.html.twig', [
            'form' => $form->createView(),
            'tab' => $tabuser,

        ]);
    }
}


class Stat
{
    const num = 0;
    const name = '';

    function setNum($num)
    {
        $this->num = $num;
    }
    function setName($name)
    {
        $this->name = $name;
    }
}
