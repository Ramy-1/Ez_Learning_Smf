<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReponserecType;
use App\Entity\Reponserec;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReponserecRepository;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ReponseRecController extends AbstractController
{
    /**
     * @Route("/reponse/rec", name="app_reponse_rec")
     */
    public function index(): Response
    {
        return $this->render('reponse_rec/index.html.twig', [
            'controller_name' => 'ReponseRecController',
        ]);
    }
 /**
     * @Route("/listReponse", name="listReponse")
     */
    public function listStudenReponse()
    {
       
        $reponses = $this->getDoctrine()->getRepository(Reponserec::class)->findAll();
        $count1 = sizeof($reponses);
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $count2 = sizeof($reclamations);
        return $this->render('reponse_rec/list.html.twig', ["reponses" => $reponses,'totRep'=>$count1,'totRec'=>$count2]);
    }
      /**
     * @Route("/addReponse{idrec}", name="addReponse")
     */
    public function addReponse(Request $request , $idrec)
    {
        $reponserec = new Reponserec();
        $reponserec->setIdreclamation($idrec);
        $reponserec->setDaterep(new \DateTime('now'));
        $form = $this->createForm(ReponserecType::class, $reponserec);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$reclamation->setMoyenne(0);
            $em->persist($reponserec);
            $em->flush();
            return $this->redirectToRoute('listReponse');
        }
        return $this->render("reponse_rec/add.html.twig", array('form' => $form->createView()));
    }

     /**
     * @Route("/deleteReponse/{idreponse}", name="deleteReponse")
     */
    public function deleteReponse($idreponse)
    {
        $reponserec = $this->getDoctrine()->getRepository(Reponserec::class)->find($idreponse);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reponserec);
        $em->flush();
        return $this->redirectToRoute("listReponse");
    }

       /**
     * @Route("/updateReponse/{idreponse}", name="updateReponse")
     */
    public function updateReclamation(Request $request, $idreponse)
    {
        $reponserec = $this->getDoctrine()->getRepository(Reponserec::class)->find($idreponse);
        $reponserec->setDaterep(new \DateTime('now'));
        $form = $this->createForm(ReponserecType::class, $reponserec);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listReponse');
        }
        return $this->render("reponse_rec/update.html.twig", array('form' => $form->createView()));
    }
      /**
      * @Route("/StatReponse", name="StatReponse")
      */
    public function statistiqueTraites(ReclamationRepository $RPR)
    {
        $reponses = $this->getDoctrine()->getRepository(Reponserec::class)->findAll();
        $count1 = sizeof($reponses);
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $count2 = sizeof($reclamations);
        $count3 = $count2 - $count1 ;
        $typeT = "Technique";
        $rtech = $RPR->alltech();
        $count4 = sizeof($rtech);
        $count5 = $count2-$count4;
        return $this->render('reponse_rec/Stat.html.twig', ['totRep'=>$count1,'totRec'=>$count2 ,'totNon'=>$count3,'totech'=>$count4,'totcours'=>$count5]);
    }


}
