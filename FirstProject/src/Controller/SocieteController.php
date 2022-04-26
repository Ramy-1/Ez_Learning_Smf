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
    public function listFrontStudenSocietes(PaginatorInterface $paginator,Request $request)
    {
        $donnees = $this->getDoctrine()->getRepository(Societe::class)->findAll();
        $societes= $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            3);
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

}
