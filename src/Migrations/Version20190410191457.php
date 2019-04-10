<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410191457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vente_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AB1EBEFA44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C3F2DF6D44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4F28772D44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_855E532E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destinateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, processus VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_448D025C44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente_vignette ADD CONSTRAINT FK_AB1EBEFA44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE stock_navette ADD CONSTRAINT FK_C3F2DF6D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE stock_taxe ADD CONSTRAINT FK_4F28772D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE vente_navette ADD CONSTRAINT FK_855E532E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE stock_vignette ADD CONSTRAINT FK_448D025C44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE user ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE billet_ptb ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_76110B65FD02F13 ON billet_ptb (evenement_id)');
        $this->addSql('ALTER TABLE trajet_event ADD depart_id INT NOT NULL, ADD arrivee_id INT NOT NULL, DROP depart, DROP arrivee');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDAE02FE4B ON trajet_event (depart_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDEAF07E42 ON trajet_event (arrivee_id)');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CFD02F13');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD02F13 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP evenement_id');
        $this->addSql('ALTER TABLE vignette DROP prix');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vente_vignette');
        $this->addSql('DROP TABLE stock_navette');
        $this->addSql('DROP TABLE stock_taxe');
        $this->addSql('DROP TABLE vente_navette');
        $this->addSql('DROP TABLE destinateur');
        $this->addSql('DROP TABLE stock_vignette');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65FD02F13');
        $this->addSql('DROP INDEX IDX_76110B65FD02F13 ON billet_ptb');
        $this->addSql('ALTER TABLE billet_ptb DROP evenement_id');
        $this->addSql('ALTER TABLE trajet ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD02F13 ON trajet (evenement_id)');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDAE02FE4B');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDEAF07E42');
        $this->addSql('DROP INDEX UNIQ_8DC7EEDDAE02FE4B ON trajet_event');
        $this->addSql('DROP INDEX UNIQ_8DC7EEDDEAF07E42 ON trajet_event');
        $this->addSql('ALTER TABLE trajet_event ADD depart VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD arrivee VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP depart_id, DROP arrivee_id');
        $this->addSql('ALTER TABLE user DROP active');
        $this->addSql('ALTER TABLE vignette ADD prix INT NOT NULL');
    }
}
