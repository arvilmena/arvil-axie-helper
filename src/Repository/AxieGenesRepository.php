<?php

namespace App\Repository;

use App\Entity\AxieGenes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AxieGenes|null find($id, $lockMode = null, $lockVersion = null)
 * @method AxieGenes|null findOneBy(array $criteria, array $orderBy = null)
 * @method AxieGenes[]    findAll()
 * @method AxieGenes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxieGenesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AxieGenes::class);
    }

    // /**
    //  * @return AxieGenes[] Returns an array of AxieGenes objects
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
    public function findOneBySomeField($value): ?AxieGenes
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
