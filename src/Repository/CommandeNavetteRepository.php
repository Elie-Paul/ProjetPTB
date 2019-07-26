<?php

namespace App\Repository;

use App\Entity\CommandeNavette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
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

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateCommandeNavette()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE commande_navette';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function stockZero()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE stock_navette SET nbre=0 WHERE billet_id IS NOT NULL';
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
        UPDATE billet_navette SET numero_dernier_billet=1 WHERE guichet_id IS NOT NULL';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateVenteNavette()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE vente_navette';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
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
