<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321084032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, abonnement_id INT DEFAULT NULL, annee VARCHAR(4) NOT NULL, mois VARCHAR(50) NOT NULL, INDEX IDX_6D28840DF1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INT NOT NULL, section VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(150) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(9) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_351268BBC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(25) NOT NULL, ADD prenom VARCHAR(25) NOT NULL, ADD email VARCHAR(50) NOT NULL, ADD created_at DATETIME NOT NULL, ADD filename VARCHAR(255) NOT NULL, ADD update_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBC54C8C93');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF1D74413');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP email, DROP created_at, DROP filename, DROP update_at');
    }
}
