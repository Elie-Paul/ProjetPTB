<?php

namespace App\Repository;

use App\Entity\Tracabilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tracabilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tracabilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tracabilite[]    findAll()
 * @method Tracabilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TracabiliteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tracabilite::class);
    }

    // /**
    //  * @return Tracabilite[] Returns an array of Tracabilite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tracabilite
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
