<?php

namespace App\Repository;

use App\Entity\Axie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Axie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Axie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Axie[]    findAll()
 * @method Axie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Axie::class);
    }

    // /**
    //  * @return Axie[] Returns an array of Axie objects
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
    public function findOneBySomeField($value): ?Axie
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
