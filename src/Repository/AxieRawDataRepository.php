<?php

namespace App\Repository;

use App\Entity\AxieRawData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AxieRawData|null find($id, $lockMode = null, $lockVersion = null)
 * @method AxieRawData|null findOneBy(array $criteria, array $orderBy = null)
 * @method AxieRawData[]    findAll()
 * @method AxieRawData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxieRawDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AxieRawData::class);
    }

    // /**
    //  * @return AxieRawData[] Returns an array of AxieRawData objects
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
    public function findOneBySomeField($value): ?AxieRawData
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
