<?php

namespace App\Repository;

use App\Entity\BilletEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BilletEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilletEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilletEvent[]    findAll()
 * @method BilletEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BilletEvent::class);
    }

    // /**
    //  * @return BilletEvent[] Returns an array of BilletEvent objects
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
    public function findOneBySomeField($value): ?BilletEvent
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
