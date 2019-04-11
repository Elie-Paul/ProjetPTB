<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410212123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet_event ADD depart_id INT NOT NULL, ADD arrivee_id INT NOT NULL, DROP depart, DROP arrivee');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDAE02FE4B ON trajet_event (depart_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DC7EEDDEAF07E42 ON trajet_event (arrivee_id)');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CFD02F13');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD02F13 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP evenement_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD02F13 ON trajet (evenement_id)');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDAE02FE4B');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDEAF07E42');
        $this->addSql('DROP INDEX UNIQ_8DC7EEDDAE02FE4B ON trajet_event');
        $this->addSql('DROP INDEX UNIQ_8DC7EEDDEAF07E42 ON trajet_event');
        $this->addSql('ALTER TABLE trajet_event ADD depart VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD arrivee VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP depart_id, DROP arrivee_id');
    }
}
