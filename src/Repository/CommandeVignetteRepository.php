<?php

namespace App\Repository;

use App\Entity\CommandeVignette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
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

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateCommandeVignette()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE commande_vignette';
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
        UPDATE stock_vignette SET nbre=0 WHERE billet_id IS NOT NULL';
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
        UPDATE vignette SET numero_dernier_billet=1 WHERE guichet_id IS NOT NULL';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return void Returns an array of CommandePtb objects
     * @throws DBALException
     */
    public function truncateVenteVignette()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        TRUNCATE TABLE vente_vignette';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
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
