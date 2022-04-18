<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\UserFavorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/front")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front")
     */
    public function index(): Response
    {
        return $this->render('front/signin.html.twig', [
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

            $tab += $o->getCour();
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
