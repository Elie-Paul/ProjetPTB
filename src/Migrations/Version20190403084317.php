<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403084317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stock_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3531B85244973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C8234B5E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_ptb ADD CONSTRAINT FK_3531B85244973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE vente_ptb ADD CONSTRAINT FK_C8234B5E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE billet_ptb DROP INDEX UNIQ_76110B65BE9DC9C7, ADD INDEX IDX_76110B65BE9DC9C7 (ptb_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE stock_ptb');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE vente_ptb');
        $this->addSql('ALTER TABLE billet_ptb DROP INDEX IDX_76110B65BE9DC9C7, ADD UNIQUE INDEX UNIQ_76110B65BE9DC9C7 (ptb_id)');
    }
}
