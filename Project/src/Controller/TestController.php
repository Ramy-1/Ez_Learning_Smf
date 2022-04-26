<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * @Route("/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="app_test_index", methods={"GET"})
     */
    public function index(TestRepository $testRepository): Response
    {
        $user=$this->getUser();
        $role=$user->getRoles();
        if(in_array("ROLE_ENSIEGNANT",$role,true)){
            $tests=$testRepository->findby(['user'=>$user]);
        }
        else{
            $tests=$testRepository->findAll();
        }
        return $this->render('test/index.html.twig', [
            'tests' => $tests,
            
        ]);
    }

    /**
     * @Route("/new", name="app_test_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TestRepository $testRepository): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);
        $user= $this->getUser();
        $cours=$form->get('cours')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $test->setcreatedAt(new \DateTime('now'));
            $test->setUser($user);
            $test->setCours($cours);
            $testRepository->add($test);
            return $this->redirectToRoute('app_questions_index', ['testid'=>$test->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_test_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Test $test, TestRepository $testRepository): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test->setCours(null);
            $testRepository->add($test);
            
            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test, TestRepository $testRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $testRepository->remove($test);
        }

        return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/pass/{testid}", name="app_test_pass", methods={"GET", "POST"})
     */
    public function pass(Request $request, TestRepository $testRepository,$testid,QuestionsRepository $questionsRepository): Response
    {
        
       $test=$testRepository->findoneby(['id'=>$testid]);
        $questions=$questionsRepository->findby(['test'=>$test]);
        return $this->render('test/pass_test.html.twig', [
            'test' => $test,
            'questions'=>$questions
           
        ]);
    }

   
}
