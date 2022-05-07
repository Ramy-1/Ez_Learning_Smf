<?php

namespace App\Controller;

use App\Form\SocieteType;
use App\Entity\Societe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SocieteController extends AbstractController
{
    /**
     * @Route("/societe", name="app_societe")
     */
    public function index(): Response
    {
        return $this->render('societe/index.html.twig', [
            'controller_name' => 'SocieteController',
        ]);
    }

    /**
     * @Route("/listSociete", name="listSociete")
     */
    public function listStudenSocietes()
    {
        $societes = $this->getDoctrine()->getRepository(Societe::class)->findAll();
        return $this->render('Societe/list.html.twig', ["societes" => $societes]);
    }
    /**
     * @Route("/list1Societe", name="list1Societe")
     */
    public function listFrontStudenSocietes(Request $request)
    {
        $societes = $this->getDoctrine()->getRepository(Societe::class)->findAll();
        
        return $this->render('Societe/list1.html.twig', ["societes" => $societes]);
    }
      /**
     * @Route("/addSociete", name="addSociete")
     */
    public function addSociete(Request $request)
    {
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('imgsoc')->getData();
            $fichier=$societe->getNom().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $societe->setImgsoc($fichier);
            $em = $this->getDoctrine()->getManager();
            //$societe->setMoyenne(0);
            $em->persist($societe);
            $em->flush();
            return $this->redirectToRoute('listSociete');
        }
        return $this->render("societe/add.html.twig", array('form' => $form->createView()));
    }

     /**
     * @Route("/deleteSociete/{idsoc}", name="deleteSociete")
     */
    public function deleteSociete($idsoc)
    {
        $societe = $this->getDoctrine()->getRepository(Societe::class)->find($idsoc);
        $em = $this->getDoctrine()->getManager();
        $em->remove($societe);
        $em->flush();
        return $this->redirectToRoute("listSociete");
    }

       /**
     * @Route("/updateSociete/{idsoc}", name="updateSociete")
     */
    public function updateSociete(Request $request, $idsoc)
    {
        $societe = $this->getDoctrine()->getRepository(Societe::class)->find($idsoc);
        $form = $this->createForm(SocieteType::class, $societe);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listSociete');
        }
        return $this->render("societe/update.html.twig", array('form' => $form->createView()));
    }


     /**
     * @Route("/detailSociete/{id}", name="detailSociete")
     */
    public function DetailSociete($id)
    {
        $societe = $this->getDoctrine()->getRepository(Societe::class)->find($id);

        return $this->render('societe/detail.html.twig', ["societe" => $societe]);
    }

 /**
   * Creates a new ActionItem entity.
   *
   * @Route("/search", name="ajax_search")

   */
  public function searchAction(Request $request, SocieteRepository $Sr)
  {
      $em = $this->getDoctrine()->getManager();
      $requestString = $request->get('q');
      $societe = $Sr->findEntitiesByString($requestString);
      if (!$societe) {
          $result['societes']['error'] = "societe introuvable ";
      } else {
          $result['societes'] = $this->getRealEntities($societe);
      }
      return new Response(json_encode($result));
  }


  public function getRealEntities($societes){

    foreach ($societes as $societes){
        $realEntities[$societes->getIdSoc()] = [$societes->getNom() ,$societes->getAdresse(),$societes->getImgsoc()];
    }

    return $realEntities;
}


    /**
     * @Route("/listSocieteJSON", name="listSocieteJSON")
     */
    public function listSocieteJSON(NormalizerInterface $Normalizer)
    {
        $donnees = $this->getDoctrine()->getRepository(Societe::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($donnees);
        return new JsonResponse($formatted);
    }
     /**
    * @Route("/addSocieteJSON",name="addSocieteJSON")
    */

    public function ajouterSocieteJSON(Request $request,NormalizerInterface $Normalizer)
    {
	    $em = $this->getDoctrine()->getManager();
        $Soc = new Societe();
        $Soc->setIdsoc($request->get('idsoc'));
        $Soc->setNom($request->get('nom'));
        $Soc->setEmail($request->get('email'));
        $Soc->setAdresse($request->get('adresse'));
        $Soc->setImgsoc($request->get('imgsoc'));
        $Soc->setMdpsoc($request->get('mdpsoc'));
        $em->persist($Soc);
        $em->flush();
        $jsonContent = $Normalizer->normalize($Soc, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));;
    }

    /**
    * @Route("/deleteSocieteJSON", name="deleteSocieteJSON")
    */
    public function deleteSocieteJSON(Request $request)

    {$idsoc=$request->get("idsoc");
        $em=$this->getDoctrine()->getManager();
        $societe=$em->getRepository(Societe::class)->find($idsoc);
        if($societe!=null)
        {$em->remove($societe);
            $em->flush();
            $serialize=new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("societe supprimee avec succes");
            return new JsonResponse($formatted);
        }

return new JsonResponse("idsoc invalide");
 }

       /**
    * @Route("/updateSocieteJSON", name="updateSocieteJSON")
    */
    public function updateSocieteJSON(Request $request)

    {  
        $idsoc=$request->get("idsoc");
        $em=$this->getDoctrine()->getManager();
        $Soc=$em->getRepository(Societe::class)->find($idsoc);
        $Soc->setNom($request->get('nom'));
        $Soc->setEmail($request->get('email'));
        $Soc->setAdresse($request->get('adresse'));
        $Soc->setImgsoc($request->get('imgsoc'));
        $Soc->setMdpsoc($request->get('mdpsoc'));
        $em->persist($Soc);
            $em->flush();
            $serialize=new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("societe modifiee avec succes");
            return new JsonResponse($formatted);

    }

}
