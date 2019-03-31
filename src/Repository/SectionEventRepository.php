<?php

namespace App\Repository;

use App\Entity\SectionEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SectionEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionEvent[]    findAll()
 * @method SectionEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SectionEvent::class);
    }

    // /**
    //  * @return SectionEvent[] Returns an array of SectionEvent objects
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
    public function findOneBySomeField($value): ?SectionEvent
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
