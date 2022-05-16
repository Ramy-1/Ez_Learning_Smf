<?php

namespace App\Controller;

use App\Entity\Universite;
use App\Entity\User;
use App\Entity\Categorie;
use App\Form\UniversiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/universite")
 */
class UniversiteController extends AbstractController
{
    /**
     * @Route("/", name="app_universite_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $universites = $entityManager
            ->getRepository(Universite::class)
            ->findAll();

        return $this->render('universite/index.html.twig', [
            'universites' => $universites,
        ]);
    }
    /**
     * @Route("/front", name="app_universite_indexf", methods={"GET"})
     */
    public function index2(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
       /* $universites = $entityManager
            ->getRepository(Universite::class)
            ->findAll();
        */
            $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();
         $universites = $paginator->paginate(
             $universites,
             $request->query->getInt('page', 1),
            3);

        return $this->render('universite/indexf.html.twig', [
            'universites' => $universites,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="app_universite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $universite = new Universite();
        $form = $this->createForm(UniversiteType::class, $universite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imguni')->getData();
            $fichier=$universite->getNom().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $universite->setImguni($fichier);

            $user = new User();
            $user->setName($universite->getNom());
            $user->setLastName($universite->getAdresse());
            $user->setEmail($universite->getEmail());
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $universite->getMdpuni()
                )
            );
            $user->setRoles(array("ROLE_UNIVERSITE"));
          

            $entityManager->persist($user);

            $entityManager->persist($universite);
            $entityManager->flush();

            return $this->redirectToRoute('app_universite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('universite/new.html.twig', [
            'universite' => $universite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iduni}", name="app_universite_show", methods={"GET"})
     */
    public function show(Universite $universite): Response
    {
        return $this->render('universite/show.html.twig', [
            'universite' => $universite,
        ]);
    }

    /**
     * @Route("/{iduni}/edit", name="app_universite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Universite $universite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UniversiteType::class, $universite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imguni')->getData();
            $fichier=$universite->getNom().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $universite->setImguni($fichier);
            $entityManager->flush();

            return $this->redirectToRoute('app_universite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('universite/edit.html.twig', [
            'universite' => $universite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iduni}", name="app_universite_delete", methods={"POST"})
     */
    public function delete(Request $request, Universite $universite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$universite->getIduni(), $request->request->get('_token'))) {
            $entityManager->remove($universite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_universite_index', [], Response::HTTP_SEE_OTHER);
    }
}

