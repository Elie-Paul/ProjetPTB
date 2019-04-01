<?php

namespace App\Repository;

use App\Entity\CommandeTaxe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeTaxe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeTaxe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeTaxe[]    findAll()
 * @method CommandeTaxe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeTaxeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeTaxe::class);
    }

    // /**
    //  * @return CommandeTaxe[] Returns an array of CommandeTaxe objects
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
    public function findOneBySomeField($value): ?CommandeTaxe
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
