<?php

namespace App\Repository;

use App\Entity\AxiePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AxiePart|null find($id, $lockMode = null, $lockVersion = null)
 * @method AxiePart|null findOneBy(array $criteria, array $orderBy = null)
 * @method AxiePart[]    findAll()
 * @method AxiePart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxiePartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AxiePart::class);
    }

    // /**
    //  * @return AxiePart[] Returns an array of AxiePart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AxiePart
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
