<?php

namespace App\Controller;

use App\Entity\LikeCours;
use App\Form\LikeCoursType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/like/cours")
 */
class LikeCoursController extends AbstractController
{
    /**
     * @Route("/", name="app_like_cours_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $likeCours = $entityManager
            ->getRepository(LikeCours::class)
            ->findAll();

        return $this->render('like_cours/index.html.twig', [
            'like_cours' => $likeCours,
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_like_cours_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,Int $id): Response
    {
        $likeCour = new LikeCours();
        $form = $this->createForm(LikeCoursType::class, $likeCour);
        $form->handleRequest($request);
        $likeCour->setId($id);
        $likeCour->setLikeEtat(1);

        $likeCour->setIduser(1);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($likeCour);
            $entityManager->flush();

            return $this->redirectToRoute('app_like_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('like_cours/new.html.twig', [
            'like_cour' => $likeCour,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newd/{id}", name="app_like_cours_newd", methods={"GET", "POST"})
     */
    public function new2(Request $request, EntityManagerInterface $entityManager,Int $id): Response
    {
        $likeCour = new LikeCours();
        $form = $this->createForm(LikeCoursType::class, $likeCour);
        $form->handleRequest($request);
        $likeCour->setId($id);
        $likeCour->setLikeEtat(0);

        $likeCour->setIduser(1);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($likeCour);
            $entityManager->flush();

            return $this->redirectToRoute('app_like_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('like_cours/new.html.twig', [
            'like_cour' => $likeCour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idlike}", name="app_like_cours_show", methods={"GET"})
     */
    public function show(LikeCours $likeCour): Response
    {
        return $this->render('like_cours/show.html.twig', [
            'like_cour' => $likeCour,
        ]);
    }

    /**
     * @Route("/{idlike}/edit", name="app_like_cours_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LikeCours $likeCour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LikeCoursType::class, $likeCour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_like_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('like_cours/edit.html.twig', [
            'like_cour' => $likeCour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idlike}", name="app_like_cours_delete", methods={"POST"})
     */
    public function delete(Request $request, LikeCours $likeCour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$likeCour->getIdlike(), $request->request->get('_token'))) {
            $entityManager->remove($likeCour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_like_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
