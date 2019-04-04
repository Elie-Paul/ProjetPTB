<?php

namespace App\Repository;

use App\Entity\CommandeVignette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeVignette|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeVignette|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeVignette[]    findAll()
 * @method CommandeVignette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeVignetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeVignette::class);
    }

    // /**
    //  * @return CommandeVignette[] Returns an array of CommandeVignette objects
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
    public function findOneBySomeField($value): ?CommandeVignette
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
