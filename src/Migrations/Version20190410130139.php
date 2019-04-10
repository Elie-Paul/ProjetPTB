<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410130139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vente_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_466329F544973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente_taxe ADD CONSTRAINT FK_466329F544973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE abonnement CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE stock_taxe ADD billet_id INT NOT NULL, ADD nbre INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE stock_taxe ADD CONSTRAINT FK_4F28772D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('CREATE INDEX IDX_4F28772D44973C78 ON stock_taxe (billet_id)');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CFD02F13');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD02F13 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP evenement_id');
        $this->addSql('ALTER TABLE trajet_event ADD depart_id INT NOT NULL, ADD arrivee_id INT NOT NULL, DROP depart, DROP arrivee');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDAE02FE4B ON trajet_event (depart_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDEAF07E42 ON trajet_event (arrivee_id)');
        $this->addSql('ALTER TABLE user ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE vignette DROP prix');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vente_taxe');
        $this->addSql('ALTER TABLE abonnement CHANGE filename filename VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(9) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE stock_taxe DROP FOREIGN KEY FK_4F28772D44973C78');
        $this->addSql('DROP INDEX IDX_4F28772D44973C78 ON stock_taxe');
        $this->addSql('ALTER TABLE stock_taxe DROP billet_id, DROP nbre, DROP created_at, DROP updated_at');
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
