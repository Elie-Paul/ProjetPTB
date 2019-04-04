<?php

namespace App\Repository;

use App\Entity\VenteVignette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VenteVignette|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteVignette|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteVignette[]    findAll()
 * @method VenteVignette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteVignetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VenteVignette::class);
    }

    // /**
    //  * @return VenteVignette[] Returns an array of VenteVignette objects
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
    public function findOneBySomeField($value): ?VenteVignette
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
