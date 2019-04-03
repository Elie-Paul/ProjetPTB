<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403084144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vente_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C8234B5E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_9218FF79A76ED395 (user_id), INDEX IDX_9218FF79C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DD6B4E8444973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_audit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT DEFAULT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3D5E2E0A44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3531B85244973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente_ptb ADD CONSTRAINT FK_C8234B5E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79C54C8C93 FOREIGN KEY (type_id) REFERENCES type_audit (id)');
        $this->addSql('ALTER TABLE commande_vignette ADD CONSTRAINT FK_DD6B4E8444973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE commande_taxe ADD CONSTRAINT FK_3D5E2E0A44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE stock_ptb ADD CONSTRAINT FK_3531B85244973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE billet_ptb DROP INDEX UNIQ_76110B65BE9DC9C7, ADD INDEX IDX_76110B65BE9DC9C7 (ptb_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79C54C8C93');
        $this->addSql('DROP TABLE vente_ptb');
        $this->addSql('DROP TABLE audit');
        $this->addSql('DROP TABLE commande_vignette');
        $this->addSql('DROP TABLE type_audit');
        $this->addSql('DROP TABLE commande_taxe');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE stock_ptb');
        $this->addSql('ALTER TABLE billet_ptb DROP INDEX IDX_76110B65BE9DC9C7, ADD UNIQUE INDEX UNIQ_76110B65BE9DC9C7 (ptb_id)');
    }
}
