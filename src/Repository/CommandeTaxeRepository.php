<?php

namespace App\Repository;

use App\Entity\CommandeTaxe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
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

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateCommandeTaxe()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE commande_taxe';
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
        UPDATE stock_taxe SET nbre=0 WHERE billet_id IS NOT NULL';
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
        UPDATE billet_taxe SET numero_dernier_billet=1 WHERE id IS NOT NULL';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateVenteTaxe()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE vente_taxe';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
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
