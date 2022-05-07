<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\ORM\Query;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
//use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;



class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {   parent::__construct($registry, Reclamation::class);  }
   
    public function counted()
    {
      //  $repository = $this->getRepository(Reclamation::class);
      //  $qb = $repository->createQueryBuilder('t');
        return $this->createQueryBuilder('t')
            ->select('count(t.idrec)')
            ->getQuery()
            ->getSingleScalarResult();
    }
   public function alltech(){
          return $this->createQueryBuilder('r')
               ->where("r.type LIKE :typer")
               ->setParameter('typer','Technique')
               ->getQuery()
               ->getResult();
   }
  public function alldates(){
    return $this->createQueryBuilder('R')
                ->select('R.idreclamation')
                ->join('R.idrec','c')
                ->where("c.idrec LIKE R.idreclamation")
                ->getQuery()
                ->getResult();
  }

}