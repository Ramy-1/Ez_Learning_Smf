<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cours")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/", name="app_cours_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findAll();

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }

    /**
     * @Route("/front", name="app_cours_indexf", methods={"GET"})
     */
    public function indexf(EntityManagerInterface $entityManager): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cours::class);
        $cours = $repository->findByDate();

        return $this->render('cours/indexf.html.twig', [
            'cours' => $cours,
        ]);
    }

    /**
     * @Route("/new", name="app_cours_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();
            $contact = $form->getData();
            // /* mail*/
            // $message= (new \Swift_Message('EasyLearning'))
            //     ->setTo('asmazr586@gmail.com')
            //     ->setFrom('asmazr586@gmail.com')
            //     ->setBody(
            //         $this->renderView(
            //             'emails/contact.html.twig',compact('contact')
            //         ),
            //         'text/html'
            //     )
            // ;
            // $mailer->send($message);

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/archive", name="coursarchiver", methods={"GET","POST"})
     */
    public function archiver($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $entityManager->getRepository(Cours::class)->find($id);
        $reclamation->setEtat(0);
        $entityManager->flush();
        return $this->redirectToRoute('app_cours_index');
    }
    /**
     * @Route("/{id}/activer", name="coursinarchiver", methods={"GET","POST"})
     */
    public function archiver2($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $entityManager->getRepository(Cours::class)->find($id);
        $reclamation->setEtat(1);
        $entityManager->flush();
        return $this->redirectToRoute('app_cours_index');
    }
    /**
     * @Route("/{id}", name="app_cours_show", methods={"GET"})
     */
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);

    }
    /**
     * @Route("/{id}/etatdonAction", name="reclamation_etatdonAction", methods={"GET","POST"})
     */
    public function etatdonAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $entityManager->getRepository(Cours::class)->find($id);
        $reclamation->setEtat(0);
        $entityManager->flush();
        return $this->redirectToRoute('app_cours_index');
    }

    /**
     * @Route("/{id}/edit", name="app_cours_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_cours_delete", methods={"POST"})
     */
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
