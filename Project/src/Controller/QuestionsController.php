<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Entity\ReponseEtudiant;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use App\Repository\ReponsesRepository;
use App\Repository\ReponseEtudiantRepository;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questions")
 */
class QuestionsController extends AbstractController
{
    /**
     * @Route("/test/{testid}", name="app_questions_index", methods={"GET"})
     */
    public function index(QuestionsRepository $questionsRepository,$testid,TestRepository $testRepository): Response
    {
        $test=$testRepository->findoneby(['id'=>$testid]);
        $questions=$questionsRepository->findby(['test'=>$testid]);
        return $this->render('questions/index.html.twig', [
            'questions' => $questions,
            'test'=>$test
        ]);
    }

    /**
     * @Route("/{testid}/new", name="app_questions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, QuestionsRepository $questionsRepository,$testid,TestRepository $testRepository): Response
    {
        $test=$testRepository->findoneby(['id'=>$testid]);
        $question = new Questions();
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setTest($test);
            $questionsRepository->add($question);
            
            return $this->redirectToRoute('app_questions_index', ['testid'=>$test->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
            'test'=>$test
        ]);
    }

    /**
     * @Route("/{id}", name="app_questions_show", methods={"GET"})
     */
    public function show(Questions $question,TestRepository $testRepository): Response
    {
        $test=$testRepository->findoneby(['id'=>$question->getTest()->getId()]);
        return $this->render('questions/show.html.twig', [
            'question' => $question,
            'test'=>$test
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_questions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Questions $question, QuestionsRepository $questionsRepository,TestRepository $testRepository): Response
    {
        $test=$testRepository->findoneby(['id'=>$question->getTest()->getId()]);
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionsRepository->add($question);
            return $this->redirectToRoute('app_questions_index', ['testid'=>$test->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
            'test'=>$test
        ]);
    }

    /**
     * @Route("/{id}", name="app_questions_delete", methods={"POST"})
     */
    public function delete(Request $request, Questions $question, QuestionsRepository $questionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionsRepository->remove($question);
        }

        return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
    }


     /**
     * @Route("/show/pdf/test/{id}/pdf", name="show_test_pdf", methods={"GET"})
     */
    public function showTestPdf( QuestionsRepository $questionsRepository,$id){
        $int = (int)$id;
        $question=$questionsRepository->findoneby(['id'=>$int]);
        
        //var_dump($question);
        return $this->render('test/showPdf.html.twig',["supportDocument"=>$question->getSupport(),'testId'=>$question->getId()]);
    }

        /**
     * set absence status for teachers
     * @param Request $request
     * @return Response
     * @Route("/student/response", name="question_response")
     */
    public function reponseqcmAction(Request $request,ReponsesRepository $reponsesRepository,ReponseEtudiantRepository $ReponseEtudiantRepository)
    {
        $reponseId=$request->get('reponseId');
        $reponsee=$reponsesRepository->findOneBy(['id'=>$reponseId]);
        $question=$reponsee->getQuestion();
        
        
        $response=$ReponseEtudiantRepository->findOneBy(['reponse'=>$reponseId]);
        $entityManager = $this->getDoctrine()->getManager();
        if($response == null){
            $res = new ReponseEtudiant();

            $res->setReponse($reponsee);
            $res->setQuestion($question);
            $res->setIsCorrect($reponsee->getIsCorrect());
            $res->setNote($reponsee->getNote());
            $entityManager->persist($res);
            $entityManager->flush();
        }
        else{
            $response->setReponse($reponsee);
            $response->setQuestion($question);
            $response->setIsCorrect($reponsee->getIsCorrect());
            $response->setNote($reponsee->getNote());
            $entityManager->persist($response);
            $entityManager->flush();
        }
       
        return new Response();
    }
       /**
     * set absence status for teachers
     * @param Request $request
     * @return Response
     * @Route("/student/response/remove", name="question_response_remove")
     */
    public function removereponse(Request $request,ReponsesRepository $reponsesRepository,ReponseEtudiantRepository $ReponseEtudiantRepository)
    {
        $reponseId=$request->get('reponseId');
        $reponsee=$reponsesRepository->findOneBy(['id'=>$reponseId]);
        $question=$reponsee->getQuestion();
      
        
        $response=$ReponseEtudiantRepository->findOneBy(['reponse'=>$reponseId]);
        $ReponseEtudiantRepository->remove($response);
        $entityManager = $this->getDoctrine()->getManager();
       
       
        return new Response();
    }
}
