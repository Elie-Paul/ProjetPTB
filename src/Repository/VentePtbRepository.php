<?php

namespace App\Repository;

use App\Entity\VentePtb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VentePtb|null find($id, $lockMode = null, $lockVersion = null)
 * @method VentePtb|null findOneBy(array $criteria, array $orderBy = null)
 * @method VentePtb[]    findAll()
 * @method VentePtb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VentePtbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VentePtb::class);
    }

    // /**
    //  * @return VentePtb[] Returns an array of VentePtb objects
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
    public function findOneBySomeField($value): ?VentePtb
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
