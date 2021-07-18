<?php

namespace App\Repository;

use App\Entity\CrawlAxieResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CrawlAxieResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrawlAxieResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrawlAxieResult[]    findAll()
 * @method CrawlAxieResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrawlAxieResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CrawlAxieResult::class);
    }

    // /**
    //  * @return CrawlAxieResult[] Returns an array of CrawlAxieResult objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CrawlAxieResult
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
