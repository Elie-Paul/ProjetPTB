<?php

namespace App\Repository;

use App\Entity\StockNavette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StockNavette|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockNavette|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockNavette[]    findAll()
 * @method StockNavette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockNavetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StockNavette::class);
    }

    // /**
    //  * @return StockNavette[] Returns an array of StockNavette objects
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
    public function findOneBySomeField($value): ?StockNavette
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
