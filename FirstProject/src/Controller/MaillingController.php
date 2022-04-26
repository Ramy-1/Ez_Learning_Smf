<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MaillingController extends AbstractController
{
    /**
     * @Route("/mailling", name="app_mailling")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $tabuser = $repository->findAll();
        
        return $this->render('mailling/index.html.twig', [
            // 'controller_name' => 'MaillingController',
            'tab' => $tabuser,
        ]);
    }
    /**
     * @Route("/mails/{list}", name="app_maillings")
     */
    public function Multipale($list): Response
    {
        // $repository = $this->getDoctrine()->getRepository(User::class);
        // $tabuser = $repository->findAll();


        
        return $this->render('mailling/index.html.twig', [
            // 'controller_name' => 'MaillingController',
            'tab' => $list,
        ]);
    }

    public function notif($user,$subject,$event,MailerInterface $mailer){
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
                ->htmlTemplate('mailling/notifEvent.html.html.twig')
                ->context([
                    'desc' => $event->getDescription(),
                    'l' => $event->getLien(),
                    'd' => $event->getDate(),
                    'h' => $event->getHeure(),
                ])
                ;

            $mailer->send($email);
    }
}
