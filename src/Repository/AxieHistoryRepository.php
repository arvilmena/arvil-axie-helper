<?php

namespace App\Repository;

use App\Entity\Axie;
use App\Entity\AxieHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AxieHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AxieHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AxieHistory[]    findAll()
 * @method AxieHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AxieHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AxieHistory::class);
    }

    /**
     * @param $axieId
     * @return AxieHistory|null
     */
    public function pickAxiesLast($axieId)
    {
        try {
            return $this->createQueryBuilder('a')
                ->andWhere('a.axie = :axieId')
                ->setParameter('axieId', $axieId)
                ->orderBy('a.date', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    // /**
    //  * @return AxieHistory[] Returns an array of AxieHistory objects
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
    public function findOneBySomeField($value): ?AxieHistory
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
