<?php

namespace App\Repository;

use App\Entity\StockTaxe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StockTaxe|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockTaxe|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockTaxe[]    findAll()
 * @method StockTaxe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockTaxeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StockTaxe::class);
    }

    // /**
    //  * @return StockTaxe[] Returns an array of StockTaxe objects
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
    public function findOneBySomeField($value): ?StockTaxe
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
