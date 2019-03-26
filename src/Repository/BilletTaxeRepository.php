<?php

namespace App\Repository;

use App\Entity\BilletTaxe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BilletTaxe|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilletTaxe|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilletTaxe[]    findAll()
 * @method BilletTaxe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletTaxeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BilletTaxe::class);
    }

    // /**
    //  * @return BilletTaxe[] Returns an array of BilletTaxe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BilletTaxe
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
