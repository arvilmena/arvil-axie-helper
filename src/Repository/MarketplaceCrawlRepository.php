<?php

namespace App\Repository;

use App\Entity\MarketplaceCrawl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarketplaceCrawl|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketplaceCrawl|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketplaceCrawl[]    findAll()
 * @method MarketplaceCrawl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketplaceCrawlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketplaceCrawl::class);
    }

    public function pickWatchlistLowestAveragePriceBetweenDate($watchlistId, \DateTimeInterface $date1, $date2 = 'now')
    {
        if ('now' === $date2) {
            $date2 = new \DateTime('now');
        }
        $earliest = $date1;
        $oldest = $date2;
        if ( $date2 < $date1 ) {
            $earliest = $date2;
            $oldest = $date1;
        }

        return $this->createQueryBuilder('c')
            ->setMaxResults(1)
            ->addOrderBy('c.averagePriceUsd', 'DESC')
            ->andWhere('c.averagePriceUsd IS NOT NULL')
            ->andWhere('c.marketplaceWatchlist = :watchlistId')
            ->setParameter('watchlistId', $watchlistId)
            ->andWhere('c.crawlDate BETWEEN :earliest and :oldest')
            ->setParameter('earliest', $earliest)
            ->setParameter('oldest', $oldest)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function pickWatchlistLowestPriceBetweenDate($watchlistId, \DateTimeInterface $date1, $date2 = 'now')
    {
        if ('now' === $date2) {
            $date2 = new \DateTime('now');
        }
        $earliest = $date1;
        $oldest = $date2;
        if ( $date2 < $date1 ) {
            $earliest = $date2;
            $oldest = $date1;
        }

        return $this->createQueryBuilder('c')
            ->setMaxResults(1)
            ->addOrderBy('c.lowestPriceUsd', 'DESC')
            ->andWhere('c.lowestPriceUsd IS NOT NULL')
            ->andWhere('c.marketplaceWatchlist = :watchlistId')
            ->setParameter('watchlistId', $watchlistId)
            ->andWhere('c.crawlDate BETWEEN :earliest and :oldest')
            ->setParameter('earliest', $earliest)
            ->setParameter('oldest', $oldest)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return MarketplaceCrawl[] Returns an array of MarketplaceCrawl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarketplaceCrawl
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
