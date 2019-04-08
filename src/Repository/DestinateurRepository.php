<?php

namespace App\Repository;

use App\Entity\Destinateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Destinateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destinateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destinateur[]    findAll()
 * @method Destinateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Destinateur::class);
    }

    // /**
    //  * @return Destinateur[] Returns an array of Destinateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Destinateur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
