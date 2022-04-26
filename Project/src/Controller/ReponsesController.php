<?php

namespace App\Controller;

use App\Entity\Reponses;
use App\Form\ReponsesType;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reponses")
 */
class ReponsesController extends AbstractController
{
    /**
     * @Route("/question/{questionid}", name="app_reponses_index", methods={"GET"})
     */
    public function index(ReponsesRepository $reponsesRepository, QuestionsRepository $questionsRepository,$questionid): Response
    {
        $question=$questionsRepository->findoneby(['id'=>$questionid]);
        $reponses=$reponsesRepository->findby(['question'=>$questionid]);
        return $this->render('reponses/index.html.twig', [
            'reponses' => $reponses,
            'question'=>$question
        ]);
    }

    /**
     * @Route("/{questionid}/new", name="app_reponses_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReponsesRepository $reponsesRepository,$questionid, QuestionsRepository $questionsRepository): Response
    {
        $question=$questionsRepository->findoneby(['id'=>$questionid]);
        $reponse = new Reponses();
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setQuestion($question);
            $data = $form->getData();
            if($data->getisCorrect()) {
                $reponse->setisCorrect(true);
            } else {
                $reponse->setisCorrect(false);
            }
            
            $reponsesRepository->add($reponse);
            return $this->redirectToRoute('app_reponses_index', ['questionid'=>$question->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponses/new.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
            'question'=>$question
        ]);
    }

    /**
     * @Route("/{id}", name="app_reponses_show", methods={"GET"})
     */
    public function show(Reponses $reponse, QuestionsRepository $questionsRepository): Response
    {
        $question=$questionsRepository->findoneby(['id'=>$reponse->getQuestion()->getId()]);
        return $this->render('reponses/show.html.twig', [
            'reponse' => $reponse,
            'question'=>$question
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reponses_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reponses $reponse, ReponsesRepository $reponsesRepository): Response
    {
        
        $question=$reponse->getQuestion();
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            if($data->getisCorrect()) {

                $reponse->setisCorrect(true);
                
            } else {
                $reponse->setisCorrect(false);
            }
            $reponsesRepository->add($reponse);
            return $this->redirectToRoute('app_reponses_index', ['questionid'=>$question->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponses/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
            'question'=>$question
        ]);
    }

    /**
     * @Route("/{id}", name="app_reponses_delete", methods={"POST"})
     */
    public function delete(Request $request, Reponses $reponse, ReponsesRepository $reponsesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $reponsesRepository->remove($reponse);
        }

        return $this->redirectToRoute('app_reponses_index', [], Response::HTTP_SEE_OTHER);
    }
}
