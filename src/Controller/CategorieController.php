<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="app_categorie_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/front", name="app_categorie_indexf", methods={"GET"})
     */
    public function indexf(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/indexf.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="app_categorie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        $badWords = $this->filterwords($categorie->getDomaine() . ' ' . $categorie->getNomcat());
        if (strpos($badWords, '**') !== false) {
            $this->addFlash('info', 'Faites attention a ce que vous tapez  ! un peu de respect !!');
        } else {

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($categorie);
                $entityManager->flush();
                $this->addFlash(
                    'info',
                    'added succesfully'

                );
                return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
    function filterwords($text){
        $delimiter = ',';
        $enclosure = '"';
        $header = NULL;
        $data = array();

        if (($handle = fopen("https://docs.google.com/spreadsheets/d/10P3ihV-l2Hz9Jm1Cprp8S7mTKqYsOZWxzaNOC8ij72M/export?format=csv", 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {

                if(!$header) {
                    $header = $row;
                } else {
                    array_push($data,$row);
                }
            }
            fclose($handle);
        }
        #dd($data[300][0]);
        $filterWords = array('badword');
        foreach($data as $s)
        {
            array_push($filterWords,$s[0]);
        }
        #dd($filterWords);
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }

    /**
     * @Route("/{idcat}", name="app_categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/{idcat}/edit", name="app_categorie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcat}", name="app_categorie_delete", methods={"POST"})
     */
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdcat(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
