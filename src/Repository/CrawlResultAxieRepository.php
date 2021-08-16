<?php

namespace App\Repository;

use App\Entity\CrawlResultAxie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CrawlResultAxie|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrawlResultAxie|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrawlResultAxie[]    findAll()
 * @method CrawlResultAxie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrawlResultAxieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CrawlResultAxie::class);
    }

    // /**
    //  * @return CrawlResultAxie[] Returns an array of CrawlResultAxie objects
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
    public function findOneBySomeField($value): ?CrawlResultAxie
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
