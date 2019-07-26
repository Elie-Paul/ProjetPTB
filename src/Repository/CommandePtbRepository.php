<?php

namespace App\Repository;

use App\Entity\CommandePtb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
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

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncatePtb()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE commande_ptb';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
//        return $stmt->fetchAll();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function stockZero()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE stock_ptb SET nbre=0 WHERE billet_id IS NOT NULL';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function numeroDernierBillet()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE billet_ptb SET numero_dernier_billets=1 WHERE guichet_id IS NOT NULL';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateVentePtb()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE vente_ptb';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }


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
