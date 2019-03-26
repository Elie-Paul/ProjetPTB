<?php

namespace App\Repository;

use App\Entity\Ly;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ly|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ly|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ly[]    findAll()
 * @method Ly[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ly::class);
    }

    // /**
    //  * @return Ly[] Returns an array of Ly objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ly
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
