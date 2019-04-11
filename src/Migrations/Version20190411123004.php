<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411123004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet_ptb ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_76110B65FD02F13 ON billet_ptb (evenement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65FD02F13');
        $this->addSql('DROP INDEX IDX_76110B65FD02F13 ON billet_ptb');
        $this->addSql('ALTER TABLE billet_ptb DROP evenement_id');
    }
}
