<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403155206 extends AbstractMigration
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
        $this->addSql('ALTER TABLE vente_vignette ADD CONSTRAINT FK_AB1EBEFA44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE stock_vignette ADD billet_id INT NOT NULL, ADD nbre INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE stock_vignette ADD CONSTRAINT FK_448D025C44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_448D025C44973C78 ON stock_vignette (billet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vente_vignette');
        $this->addSql('ALTER TABLE stock_vignette DROP FOREIGN KEY FK_448D025C44973C78');
        $this->addSql('DROP INDEX UNIQ_448D025C44973C78 ON stock_vignette');
        $this->addSql('ALTER TABLE stock_vignette DROP billet_id, DROP nbre, DROP created_at, DROP updated_at');
    }
}
