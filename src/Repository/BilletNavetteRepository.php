<?php

namespace App\Repository;

use App\Entity\BilletNavette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BilletNavette|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilletNavette|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilletNavette[]    findAll()
 * @method BilletNavette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletNavetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BilletNavette::class);
    }

    // /**
    //  * @return BilletNavette[] Returns an array of BilletNavette objects
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
    public function findOneBySomeField($value): ?BilletNavette
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
