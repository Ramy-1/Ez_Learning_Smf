<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\UserFavorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/front")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        if ($user = $this->getUser()) {
            if ($user->isBlocked()) {
                $errormsg = 'User blocker par Admin';
            } else if (!$user->IsVerified()) {
                $errormsg = 'Mail pas encour verifier';
            } else {
                // if ($user->isVerified()) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return $this->redirectToRoute('app_user');
                }
                if (in_array('ROLE_ETUDIANT', $user->getRoles())) {
                    return $this->redirectToRoute('app_front');
                }
                if (in_array('ROLE_RECRUTEUR', $user->getRoles())) {
                    return $this->redirectToRoute('recruteur_home');
                }
                if (in_array('ROLE_ENSIEGNANT', $user->getRoles())) {
                    return $this->redirectToRoute('ensiegnant_home');
                }
                if (in_array('ROLE_UNIVERSITE', $user->getRoles())) {
                    return $this->redirectToRoute('universite_home');
                }
                if (in_array('ROLE_SOCIETE', $user->getRoles())) {
                    return $this->redirectToRoute('societe_home');
                }

                return $this->redirectToRoute('app_front');
                // }
            }
        }
        return $this->render('front/signin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'controller_name' => 'FrontController',
        ]);
    }
    /**
     * @Route("/favoriet", name="front_favorite")
     */
    public function favoriet(): Response
    {
        $id = $this->getUser()->getId();
        $K = $this->getDoctrine()
            ->getRepository(UserFavorite::class)
            ->findBy(['user' => $id]);

        $tab = [];
        foreach ($K as $o) {
            array_push($tab , $o->getCour());
        };
        $tabc = $this->getDoctrine()
            ->getRepository(Cours::class)
            ->findAll();

        return $this->render('front/index.html.twig', [
            'tab' => $tab,
            'tabc' => $tabc,
        ]);
    }

    /**
     *  @Route("/newfav/{id}", name="AddToFav")
     */
    public function AjoutCommand($id, Request $request): Response
    {
        $fav = new UserFavorite();

        $repository = $this->getDoctrine()->getRepository(Cours::class);
        $cour = $repository->find($id);

        $fav->setUser($this->getUser());
        $fav->setCour($cour);

        $em = $this->getDoctrine()->getManager();

        $em->persist($fav);
        $em->flush();

        return $this->redirectToRoute('front_favorite');
    }
}
