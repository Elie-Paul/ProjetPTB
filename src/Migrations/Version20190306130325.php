<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306130325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tracabilite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ptb_id INT DEFAULT NULL, navette_id INT DEFAULT NULL, type VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7E1E9A8AA76ED395 (user_id), INDEX IDX_7E1E9A8ABE9DC9C7 (ptb_id), INDEX IDX_7E1E9A8ADD1420CC (navette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_ptb (id INT AUTO_INCREMENT NOT NULL, ptb_id INT DEFAULT NULL, guichet_id INT NOT NULL, numero_dernier_billets INT NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_76110B65BE9DC9C7 (ptb_id), INDEX IDX_76110B65D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ABE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ADD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65BE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tracabilite');
        $this->addSql('DROP TABLE billet_ptb');
    }
}
