<?php

namespace App\Repository;

use App\Entity\VenteTaxe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VenteTaxe|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteTaxe|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteTaxe[]    findAll()
 * @method VenteTaxe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteTaxeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VenteTaxe::class);
    }

    // /**
    //  * @return VenteTaxe[] Returns an array of VenteTaxe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VenteTaxe
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
