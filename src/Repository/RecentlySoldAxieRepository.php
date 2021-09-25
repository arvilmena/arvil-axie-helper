<?php

namespace App\Repository;

use App\Entity\Axie;
use App\Entity\RecentlySoldAxie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecentlySoldAxie|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecentlySoldAxie|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecentlySoldAxie[]    findAll()
 * @method RecentlySoldAxie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecentlySoldAxieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecentlySoldAxie::class);
    }

    public function hasBeenSoldBetween(Axie $axie, float $priceEth, \DateTimeInterface $date1, $date2 = 'now') {

        if ('now' === $date2) {
            $date2 = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        $earliest = $date1;
        $oldest = $date2;
        if ( $date2 < $date1 ) {
            $earliest = $date2;
            $oldest = $date1;
        }

        $qb = $this->createQueryBuilder('r');
        $result = $qb
                    ->andWhere('r.axie = :axie')
                    ->setParameter('axie', $axie)
                    ->andWhere('r.date BETWEEN :earliest and :oldest')
                    ->setParameter('earliest', $earliest->format('Y-m-d H:i:s'))
                    ->setParameter('oldest', $oldest->format('Y-m-d H:i:s'))
                    ->andWhere('r.priceEth = :priceEth')
                    ->setParameter('priceEth', $priceEth)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

        return ($result !== null);
    }

    // /**
    //  * @return RecentlySoldAxie[] Returns an array of RecentlySoldAxie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecentlySoldAxie
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
