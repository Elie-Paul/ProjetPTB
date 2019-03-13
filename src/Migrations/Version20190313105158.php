<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313105158 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tracabilite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ptb_id INT DEFAULT NULL, navette_id INT DEFAULT NULL, type VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, motif LONGTEXT NOT NULL, num_depart INT NOT NULL, num_fin INT NOT NULL, INDEX IDX_7E1E9A8AA76ED395 (user_id), INDEX IDX_7E1E9A8ABE9DC9C7 (ptb_id), INDEX IDX_7E1E9A8ADD1420CC (navette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_navette (id INT AUTO_INCREMENT NOT NULL, navette_id INT NOT NULL, guichet_id INT NOT NULL, numero_dernier_billet INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_13476BB4DD1420CC (navette_id), INDEX IDX_13476BB4D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(35) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guichet (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3C05CCE96AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, depart_id INT NOT NULL, arrivee_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2B5BA98CAE02FE4B (depart_id), INDEX IDX_2B5BA98CEAF07E42 (arrivee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_ptb (id INT AUTO_INCREMENT NOT NULL, ptb_id INT DEFAULT NULL, guichet_id INT NOT NULL, numero_dernier_billets INT NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_76110B65BE9DC9C7 (ptb_id), INDEX IDX_76110B65D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ptb (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, section_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_435F0DC4D12A823 (trajet_id), INDEX IDX_435F0DC4D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, prix INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navette (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, classe_id INT NOT NULL, prix INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DA54CFCED12A823 (trajet_id), INDEX IDX_DA54CFCE8F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ABE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ADD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4DD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE guichet ADD CONSTRAINT FK_3C05CCE96AB213CC FOREIGN KEY (lieu_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65BE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE ptb ADD CONSTRAINT FK_435F0DC4D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE ptb ADD CONSTRAINT FK_435F0DC4D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE navette ADD CONSTRAINT FK_DA54CFCED12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE navette ADD CONSTRAINT FK_DA54CFCE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guichet DROP FOREIGN KEY FK_3C05CCE96AB213CC');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CAE02FE4B');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CEAF07E42');
        $this->addSql('ALTER TABLE billet_navette DROP FOREIGN KEY FK_13476BB4D75742EE');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65D75742EE');
        $this->addSql('ALTER TABLE ptb DROP FOREIGN KEY FK_435F0DC4D12A823');
        $this->addSql('ALTER TABLE navette DROP FOREIGN KEY FK_DA54CFCED12A823');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8ABE9DC9C7');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65BE9DC9C7');
        $this->addSql('ALTER TABLE ptb DROP FOREIGN KEY FK_435F0DC4D823E37A');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8AA76ED395');
        $this->addSql('ALTER TABLE navette DROP FOREIGN KEY FK_DA54CFCE8F5EA509');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8ADD1420CC');
        $this->addSql('ALTER TABLE billet_navette DROP FOREIGN KEY FK_13476BB4DD1420CC');
        $this->addSql('DROP TABLE tracabilite');
        $this->addSql('DROP TABLE billet_navette');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE guichet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE billet_ptb');
        $this->addSql('DROP TABLE ptb');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE navette');
    }
}
