<?php

namespace App\Repository;

use App\Entity\BilletPtb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BilletPtb|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilletPtb|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilletPtb[]    findAll()
 * @method BilletPtb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletPtbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BilletPtb::class);
    }

    // /**
    //  * @return BilletPtb[] Returns an array of BilletPtb objects
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
    public function findOneBySomeField($value): ?BilletPtb
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
