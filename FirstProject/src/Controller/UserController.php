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
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;

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
        // ]);nnn
        
        $tabuser = $repository->findAll();

        $o = new User();
        foreach ($o as $tabuser) {
        }
        $tabStat = [0, 0, 0, 0, 0, 0];
        $names = ['','','','','','',];

        $names[0]=('ADMIN');
        $names[1]=('ETUDIANT');
        $names[2]=('RECRUTEUR');
        $names[3]=('ENSIEGNAN');
        $names[4]=('UNIVERSITE');
        $names[5]=('SOCIETE');

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
            if (in_array('ROLE_SOCIETE', $o->getRoles())) {
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
/**
     * @Route ("/students" , name="app_student")
     */
    public function findStudent()
    {
        $query = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT u FROM App:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_ETUDIANT"%');

        $users = $query->getResult();
       
       // dump($qb);
        return $this->render('user/students.html.twig', [
            
            'students' => $users,

        ]);
    }

    /**
     * @Route ("/teachers" , name="app_teachers")
     */
    public function findTeachers(CategorieRepository $categorieRepository)
    {
        $categories=$categorieRepository->findAll();
        $query = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT u FROM App:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_ENSIEGNANT"%');

        $users = $query->getResult();
       
       // dump($qb);
        return $this->render('home/teachers.html.twig', [
            
            'teachers' => $users,
            'categories'=>$categories

        ]);
    }

    /**
     * @Route ("/teachers/universite/{id}" , name="app_teachers_universite")
     */
    public function findTeachersByUniversite($id,CategorieRepository $categorieRepository,UserRepository $userRepository)
    {
       // $teachers=$userRepository->findby(['universite'=>$id]);
       $teachers=$userRepository->findAll();
        $categories=$categorieRepository->findAll();

        return $this->render('user/teacher.html.twig', [
            
            'teachers' => $teachers,
            'categories'=>$categories

        ]);
    }

    
}
