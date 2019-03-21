<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321122715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billet_navette (id INT AUTO_INCREMENT NOT NULL, navette_id INT NOT NULL, guichet_id INT NOT NULL, numero_dernier_billet INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_13476BB4DD1420CC (navette_id), INDEX IDX_13476BB4D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_commande_valider DATETIME NOT NULL, date_commande_realiser DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_440F1A9444973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4DD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE commande_ptb ADD CONSTRAINT FK_440F1A9444973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE navette DROP INDEX UNIQ_DA54CFCED12A823, ADD INDEX IDX_DA54CFCED12A823 (trajet_id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(25) NOT NULL, ADD prenom VARCHAR(25) NOT NULL, ADD email VARCHAR(50) NOT NULL, ADD created_at DATETIME NOT NULL, ADD filename VARCHAR(255) NOT NULL, ADD update_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE billet_navette');
        $this->addSql('DROP TABLE commande_ptb');
        $this->addSql('ALTER TABLE navette DROP INDEX IDX_DA54CFCED12A823, ADD UNIQUE INDEX UNIQ_DA54CFCED12A823 (trajet_id)');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP email, DROP created_at, DROP filename, DROP update_at');
    }
}
