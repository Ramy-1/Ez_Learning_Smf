<?php

namespace App\Controller;
use App\Form\ReclamationType;
use App\Entity\Reclamation;
use App\Entity\Reponserec;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReclamationRepository;
use App\Repository\ReponserecRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
    public function listStudenReclamations()
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
        $user=$this->getUser();
        
        $reclamation = new Reclamation();
        $reclamation->setDaterec(new \DateTime('now'));
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $em = $this->getDoctrine()->getManager();
            $reclamation->setIdetudiant(strval($user->getId()));
            //$reclamation->setMoyenne(0);
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('listReclamation');
        }
        $recs = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $reps = $this->getDoctrine()->getRepository(Reponserec::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $sum=0;
        foreach ($reps as $o){
            $rec = $o->getReclamation();
            $abs_diff = $o->getDaterep()->diff($rec->getDaterec())->format("%a"); //3
            $sum += $abs_diff;
        }
        $tot = sizeof($reps);
        if($tot!=0){
            $rt = $sum/$tot;
        }else{
            $rt = 0;
        }
        
    


        return $this->render("reclamation/add.html.twig",['form' => $form->createView(),'rt'=> $rt,
    "categories"=>$categories]);
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

      /**
     * @Route("/listReclamationJSON", name="listReclamationJSON")
     */
    public function listReclamationJSON(NormalizerInterface $Normalizer)
    {
        $donnees = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($donnees);
        return new JsonResponse($formatted);
    }
     /**
    * @Route("/addReclamationJSON",name="addReclamationJSON")
    */

    public function ajouterReclamationJSON(Request $request,NormalizerInterface $Normalizer)
    {
	    $em = $this->getDoctrine()->getManager();
        $rec = new Reclamation();
        $rec->setType($request->get('type'));
        $rec->setDescription($request->get('description'));
        $rec->setIdetudiant($request->get('idetudiant'));
        $rec->setIdcours($request->get('idcours'));
        $rec->setDaterec(new \DateTime('now'));
        $em->persist($rec);
        $em->flush();
        $jsonContent = $Normalizer->normalize($rec, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));;
    }

    /**
    * @Route("/deleteReclamationJSON", name="deleteReclamationJSON")
    */
    public function deleteReclamationJSON(Request $request)

    {$idrec=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($idrec);
        if($rec!=null)
        {$em->remove($rec);
            $em->flush();
            $serialize=new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("reclamation supprimee avec succes");
            return new JsonResponse($formatted);
        }

return new JsonResponse("id reclamation invalide");
 }

       /**
    * @Route("/updateReclamationJSON", name="updateReclamationJSON")
    */
    public function updateReclamationJSON(Request $request)

    {  
        $idrec=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($idrec);
        $rec->setType($request->get('type'));
        $rec->setDescription($request->get('description'));
        $rec->setIdetudiant($request->get('idetudiant'));
        $rec->setIdcours($request->get('idcours'));
        $rec->setDaterec(new \DateTime('now'));
        $em->persist($rec);
            $em->flush();
            $serialize=new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("reclamation modifiee avec succes");
            return new JsonResponse($formatted);

    }

     /**
     * @Route("/reclamation/etudiant/{id}", name="app_reclamation_etudiant")
     */
    public function indexetudiant($id): Response
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $rec=$em->getRepository(Reclamation::class)->findby(['idetudiant'=>strval($user->getId())]);
        return $this->render('reclamation/index_etudiant.html.twig', [
            'reclamations'=>$rec,
            'categories'=>$categories
        ]);
    }

}
