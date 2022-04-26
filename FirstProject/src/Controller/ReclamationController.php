<?php

namespace App\Controller;
use App\Form\ReclamationType;
use App\Entity\Reclamation;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="app_reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
   /**
     * @Route("/listReclamation", name="listReclamation")
     */
    public function listStudenReclamationsPerDateofBirtht()
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $count = sizeof($reclamations);
        return $this->render('Reclamation/list.html.twig', ["reclamations" => $reclamations,'totRec'=>$count]);
    }
      /**
     * @Route("/addReclamation", name="addReclamation")
     */
    public function addReclamation(Request $request)
    {
        $reclamation = new Reclamation();
        $reclamation->setDaterec(new \DateTime('now'));
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$reclamation->setMoyenne(0);
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('listReclamation');
        }
      

        return $this->render("reclamation/add.html.twig",array('form' => $form->createView()));
    }

     /**
     * @Route("/deleteReclamation/{idrec}", name="deleteReclamation")
     */
    public function deleteReclamation($idrec)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($idrec);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("listReclamation");
    }

       /**
     * @Route("/updateReclamation/{idrec}", name="updateReclamation")
     */
    public function updateReclamation(Request $request, $idrec)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($idrec);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listReclamation');
        }
        return $this->render("reclamation/update.html.twig", array('form' => $form->createView()));
    }
     /**
     * @Route("/ll", name="pasencore")
     */
    public function countReclamation()
    { $rec = $this->getDoctrine()->getRepository(Reclamation::class)->findAll()->count();
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $rec = $repository->count();
       
        return $this->render('Reclamation/add.html.twig', ['rec' => $rec]);

    }

}
