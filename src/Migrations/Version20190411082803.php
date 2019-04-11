<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411082803 extends AbstractMigration
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
        $this->addSql('CREATE TABLE trajet_event (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, section_id INT NOT NULL, depart_id INT NOT NULL, arrivee_id INT NOT NULL, INDEX IDX_8DC7EEDDFD02F13 (evenement_id), INDEX IDX_8DC7EEDDD823E37A (section_id), UNIQUE INDEX UNIQ_8DC7EEDDAE02FE4B (depart_id), UNIQUE INDEX UNIQ_8DC7EEDDEAF07E42 (arrivee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_event (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet_event (id)');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDD823E37A FOREIGN KEY (section_id) REFERENCES section_event (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet_event DROP FOREIGN KEY FK_65D11774D12A823');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDD823E37A');
        $this->addSql('DROP TABLE billet_event');
        $this->addSql('DROP TABLE trajet_event');
        $this->addSql('DROP TABLE section_event');
    }
}
