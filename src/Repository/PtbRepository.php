<?php

namespace App\Repository;

use App\Entity\Ptb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ptb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ptb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ptb[]    findAll()
 * @method Ptb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PtbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ptb::class);
    }

    // /**
    //  * @return Ptb[] Returns an array of Ptb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ptb
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
