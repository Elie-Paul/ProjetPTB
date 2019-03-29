<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329175336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_event DATE NOT NULL, fin_event DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_event (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_event (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, section_id INT NOT NULL, depart VARCHAR(255) NOT NULL, arrivee VARCHAR(255) NOT NULL, INDEX IDX_8DC7EEDDFD02F13 (evenement_id), INDEX IDX_8DC7EEDDD823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDD823E37A FOREIGN KEY (section_id) REFERENCES section_event (id)');
        $this->addSql('ALTER TABLE commande_ptb ADD nombre_billet_realise INT NOT NULL, ADD nombre_billet_vendu INT NOT NULL, CHANGE date_commande_valider date_commande_valider DATETIME DEFAULT NULL, CHANGE date_commande_realiser date_commande_realiser DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD02F13 ON trajet (evenement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CFD02F13');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDFD02F13');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDD823E37A');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE section_event');
        $this->addSql('DROP TABLE trajet_event');
        $this->addSql('ALTER TABLE commande_ptb DROP nombre_billet_realise, DROP nombre_billet_vendu, CHANGE date_commande_valider date_commande_valider DATETIME NOT NULL, CHANGE date_commande_realiser date_commande_realiser DATETIME NOT NULL');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD02F13 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP evenement_id');
    }
}
