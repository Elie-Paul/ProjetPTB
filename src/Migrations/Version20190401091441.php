<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401091441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT DEFAULT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3D5E2E0A44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DD6B4E8444973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_taxe ADD CONSTRAINT FK_3D5E2E0A44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE commande_vignette ADD CONSTRAINT FK_DD6B4E8444973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commande_taxe');
        $this->addSql('DROP TABLE commande_vignette');
    }
}
