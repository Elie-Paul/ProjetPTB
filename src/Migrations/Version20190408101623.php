<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408101623 extends AbstractMigration
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
        $this->addSql('ALTER TABLE stock_taxe ADD billet_id INT NOT NULL, ADD nbre INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE stock_taxe ADD CONSTRAINT FK_4F28772D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('CREATE INDEX IDX_4F28772D44973C78 ON stock_taxe (billet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vente_taxe');
        $this->addSql('ALTER TABLE stock_taxe DROP FOREIGN KEY FK_4F28772D44973C78');
        $this->addSql('DROP INDEX IDX_4F28772D44973C78 ON stock_taxe');
        $this->addSql('ALTER TABLE stock_taxe DROP billet_id, DROP nbre, DROP created_at, DROP updated_at');
    }
}
