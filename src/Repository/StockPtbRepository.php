<?php

namespace App\Repository;

use App\Entity\StockPtb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StockPtb|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockPtb|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockPtb[]    findAll()
 * @method StockPtb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockPtbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StockPtb::class);
    }

    // /**
    //  * @return StockPtb[] Returns an array of StockPtb objects
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
    public function findOneBySomeField($value): ?StockPtb
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
