<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327133629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDC45A2040');
        $this->addSql('DROP INDEX IDX_8DC7EEDDC45A2040 ON trajet_event');
        $this->addSql('ALTER TABLE trajet_event CHANGE secton_id section_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDD823E37A FOREIGN KEY (section_id) REFERENCES section_event (id)');
        $this->addSql('CREATE INDEX IDX_8DC7EEDDD823E37A ON trajet_event (section_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDD823E37A');
        $this->addSql('DROP INDEX IDX_8DC7EEDDD823E37A ON trajet_event');
        $this->addSql('ALTER TABLE trajet_event CHANGE section_id secton_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDC45A2040 FOREIGN KEY (secton_id) REFERENCES section_event (id)');
        $this->addSql('CREATE INDEX IDX_8DC7EEDDC45A2040 ON trajet_event (secton_id)');
    }
}
