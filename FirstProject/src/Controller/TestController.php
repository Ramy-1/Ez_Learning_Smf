<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\CategorieRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

use Dompdf\Dompdf;
use Dompdf\Options;

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
        $datenow=new \DateTime('now');

        return $this->render('test/index.html.twig', [
            'tests' => $tests,
            'datenow'=>$datenow
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
       
        if ($form->isSubmitted() && $form->isValid()) {
            $cours=$form->get('cours')->getData();
            dump($cours);
            $test->setcreatedAt(new \DateTime('now'));
            $test->setUser($user);
            $test->setCours($cours);
            $begin=$form['beginAt']->getData();
            $end=$form['endAt']->getData();
            if($end<$begin){
                $this->addFlash("danger", "date de fin du test doit etre superieure a celle de debut ");

                return $this->redirectToRoute('app_test_new');
            }
            $c=$testRepository->findby(['Cours'=>$cours]);
            if($c){
                $this->addFlash("danger", "Ce cours a déja un test ");

                return $this->redirectToRoute('app_test_new');
            }
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
    public function pass(Request $request, TestRepository $testRepository,$testid,QuestionsRepository $questionsRepository,CategorieRepository $categorieRepository): Response
    {
        $categories=$categorieRepository->findAll();
       $test=$testRepository->findoneby(['id'=>$testid]);
        $questions=$questionsRepository->findby(['test'=>$test]);
        return $this->render('test/pass_test.html.twig', [
            'test' => $test,
            'questions'=>$questions,
            'categories'=>$categories
           
        ]);
    }

    /**
     * @Route("/pdf/generator/{testid}", name="pdfgenerator", methods={"GET", "POST"})
     */
    public function pdfgenerator($testid,TestRepository $testRepository)
    {
        $test=$testRepository->findoneby(['id'=>$testid]);
        $user= $this->getUser();
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('default/mypdf.html.twig', [
        'title' => "Welcome to our PDF Test",
        'user'=>$user,
        'test'=>$test
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Store PDF Binary Data
    $output = $dompdf->output();
    
    // In this case, we want to write the file in the public directory
    $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';
    // e.g /var/www/project/public/mypdf.pdf
    $pdfFilepath =  $publicDirectory . '/'.$test->getTitre().''.$user->getName().' '.$user->getLastName().'.pdf';
    
    // Write file to the desired path
    file_put_contents($pdfFilepath, $output);
    
    $content = file_get_contents($pdfFilepath);

    // Send some text response
    $response = new Response();

    //set headers
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment;filename=mypdf'.$user->getName().' '.$user->getLastName().'.pdf"');

    $response->setContent($content);
    return $response;

   // return new Response("The PDF file has been succesfully generated !");
    }

   
}

