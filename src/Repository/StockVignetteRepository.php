<?php

namespace App\Repository;

use App\Entity\StockVignette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StockVignette|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockVignette|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockVignette[]    findAll()
 * @method StockVignette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockVignetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StockVignette::class);
    }

    // /**
    //  * @return StockVignette[] Returns an array of StockVignette objects
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
    public function findOneBySomeField($value): ?StockVignette
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
