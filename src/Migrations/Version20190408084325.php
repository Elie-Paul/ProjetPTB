<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408084325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE destinateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, processus VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C3F2DF6D44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_taxe (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_448D025C44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_855E532E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AB1EBEFA44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_navette ADD CONSTRAINT FK_C3F2DF6D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE stock_vignette ADD CONSTRAINT FK_448D025C44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE vente_navette ADD CONSTRAINT FK_855E532E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE vente_vignette ADD CONSTRAINT FK_AB1EBEFA44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE destinateur');
        $this->addSql('DROP TABLE stock_navette');
        $this->addSql('DROP TABLE stock_taxe');
        $this->addSql('DROP TABLE stock_vignette');
        $this->addSql('DROP TABLE vente_navette');
        $this->addSql('DROP TABLE vente_vignette');
    }
}
