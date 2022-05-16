<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Categorie;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/", name="app_evenement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            "categories"=>$categories
        ]);
    }


    /**
     * @Route("/top2events", name="top2events")
     */
    public function top2(Request $request): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository->top2();

        return $this->render('evenement/indexf.html.twig', [
            'evenements' => $evenement,
            "categories"=>$categories
        ]);
    }
    /**
     * @Route("/listp", name="app_evenement_indexx", methods={"GET"})
     */
    public function indexd(EntityManagerInterface $entityManager): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();


        // Retrieve the HTML generated in our twig file
        $html =  $this->render('evenement/listp.html.twig', [
            'evenements' => $evenements,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return $this->redirectToRoute('app_evenement_index', ["categories"=>$categories], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/front", name="app_evenement_indexf", methods={"GET"})
     */
    public function index2(EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();


        return $this->render('evenement/indexf.html.twig', [
            'evenements' => $evenements,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="app_evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imgev')->getData();
            $fichier=$evenement->getDescription().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $evenement->setImgev($fichier);
            $this->addFlash('info', 'added successfully  ');
            $entityManager->persist($evenement);
            $entityManager->flush();
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idevent}", name="app_evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{idevent}/edit", name="app_evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imgev')->getData();
            $fichier=$evenement->getDescription().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $evenement->setImgev($fichier);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idevent}", name="app_evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdevent(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
