<?php

namespace App\Repository;

use App\Entity\Scholar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scholar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scholar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scholar[]    findAll()
 * @method Scholar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScholarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scholar::class);
    }

    // /**
    //  * @return Scholar[] Returns an array of Scholar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Scholar
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
