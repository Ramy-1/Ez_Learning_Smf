<?php

namespace App\Repository;

use App\Entity\Societe;
use Doctrine\ORM\Query;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
//use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;



class SocieteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {   parent::__construct($registry, Societe::class);  }

    public function findEntitiesByString($str)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT s
            FROM App:Societe s
            WHERE s.nom LIKE :str or s.adresse LIKE :str'
              )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
}
