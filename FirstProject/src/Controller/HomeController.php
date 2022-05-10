<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TestRepository;
use App\Repository\ReponseEtudiantRepository;
use App\Repository\CategorieRepository;
use App\Entity\ReponseEtudiant;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/tests", name="app_test_home")
     */
    public function test_home(TestRepository $testRepository,ReponseEtudiantRepository $reponseEtudiantRepository,CategorieRepository $categorieRepository): Response
    {
        $user = $this->getUser();
        $categories=$categorieRepository->findAll();
        $tests=$testRepository->findall(['id' => 'DESC']);
        $rs=$this->getDoctrine()->getManager()->createQueryBuilder()
        ->select('re')
        ->from(ReponseEtudiant::class,'re')
        ->andWhere('re.user = :user')
        ->setParameter('user', $user)
        //->orderBy('u.id', 'ASC')
      //  ->setMaxResults(10)
        ->orderby('re.test')
        ->getQuery()
        ->getResult();
        //var_dump($rs);
        $datenow=new \DateTime('now');
        $resultat=$reponseEtudiantRepository->findby(['user'=>$user]);
        return $this->render('home/test_student.html.twig', [
            'controller_name' => 'HomeController',
            'tests'=>$tests,
            'results'=>$rs,
            'datenow'=>$datenow,
            'categories'=>$categories
        ]);
    }
}
