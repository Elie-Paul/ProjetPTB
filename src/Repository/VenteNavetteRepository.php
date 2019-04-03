<?php

namespace App\Repository;

use App\Entity\VenteNavette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VenteNavette|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteNavette|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteNavette[]    findAll()
 * @method VenteNavette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteNavetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VenteNavette::class);
    }

    // /**
    //  * @return VenteNavette[] Returns an array of VenteNavette objects
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
    public function findOneBySomeField($value): ?VenteNavette
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
