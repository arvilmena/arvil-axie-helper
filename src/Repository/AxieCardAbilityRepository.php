<?php

namespace App\Repository;

use App\Entity\AxieCardAbility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AxieCardAbility|null find($id, $lockMode = null, $lockVersion = null)
 * @method AxieCardAbility|null findOneBy(array $criteria, array $orderBy = null)
 * @method AxieCardAbility[]    findAll()
 * @method AxieCardAbility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxieCardAbilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AxieCardAbility::class);
    }

    // /**
    //  * @return AxieCardAbility[] Returns an array of AxieCardAbility objects
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
    public function findOneBySomeField($value): ?AxieCardAbility
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
