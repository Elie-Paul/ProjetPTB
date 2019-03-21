<?php

namespace App\Repository;

use App\Entity\CommandePtb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandePtb|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePtb|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePtb[]    findAll()
 * @method CommandePtb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandePtbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandePtb::class);
    }

    // /**
    //  * @return CommandePtb[] Returns an array of CommandePtb objects
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
    public function findOneBySomeField($value): ?CommandePtb
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
