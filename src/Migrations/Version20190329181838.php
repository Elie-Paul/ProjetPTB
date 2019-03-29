<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329181838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billet_event (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, guichet_id INT NOT NULL, UNIQUE INDEX UNIQ_65D11774D12A823 (trajet_id), INDEX IDX_65D11774D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet_event (id)');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE billet_event');
    }
}
