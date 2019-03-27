<?php

namespace App\Repository;

use App\Entity\CommandeNavette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeNavette|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeNavette|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeNavette[]    findAll()
 * @method CommandeNavette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeNavetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeNavette::class);
    }

    // /**
    //  * @return CommandeNavette[] Returns an array of CommandeNavette objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandeNavette
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
