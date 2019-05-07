<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418164426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(150) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(9) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, nombre_carte INT DEFAULT NULL, expiration DATETIME DEFAULT NULL, INDEX IDX_351268BBC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_9218FF79A76ED395 (user_id), INDEX IDX_9218FF79C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_event (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, guichet_id INT NOT NULL, UNIQUE INDEX UNIQ_65D11774D12A823 (trajet_id), INDEX IDX_65D11774D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_navette (id INT AUTO_INCREMENT NOT NULL, navette_id INT NOT NULL, guichet_id INT NOT NULL, numero_dernier_billet INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_13476BB4DD1420CC (navette_id), INDEX IDX_13476BB4D75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_ptb (id INT AUTO_INCREMENT NOT NULL, ptb_id INT DEFAULT NULL, guichet_id INT NOT NULL, evenement_id INT DEFAULT NULL, numero_dernier_billets INT NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_76110B65BE9DC9C7 (ptb_id), INDEX IDX_76110B65D75742EE (guichet_id), INDEX IDX_76110B65FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet_taxe (id INT AUTO_INCREMENT NOT NULL, numero_dernier_billet INT NOT NULL, prix INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2CEFBD6E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_commande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, nombre_billet_realise INT NOT NULL, nombre_billet_vendu INT NOT NULL, INDEX IDX_440F1A9444973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT DEFAULT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3D5E2E0A44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nombre_billet INT NOT NULL, etat_commande INT NOT NULL, date_commande DATETIME NOT NULL, date_comnande_valider DATETIME DEFAULT NULL, date_commande_realiser DATETIME DEFAULT NULL, nombre_billet_vendu INT NOT NULL, nombre_billet_realise INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DD6B4E8444973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destinateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, processus VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_event DATE NOT NULL, fin_event DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guichet (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3C05CCE96AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(35) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navette (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, classe_id INT NOT NULL, prix INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DA54CFCED12A823 (trajet_id), INDEX IDX_DA54CFCE8F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, abonnement_id INT DEFAULT NULL, annee VARCHAR(4) NOT NULL, mois VARCHAR(50) NOT NULL, INDEX IDX_6D28840DF1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ptb (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, section_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_435F0DC4D12A823 (trajet_id), INDEX IDX_435F0DC4D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, prix INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_event (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C3F2DF6D44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3531B85244973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4F28772D44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_448D025C44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tracabilite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ptb_id INT DEFAULT NULL, navette_id INT DEFAULT NULL, type VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, motif LONGTEXT NOT NULL, num_depart INT NOT NULL, num_fin INT NOT NULL, INDEX IDX_7E1E9A8AA76ED395 (user_id), INDEX IDX_7E1E9A8ABE9DC9C7 (ptb_id), INDEX IDX_7E1E9A8ADD1420CC (navette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, depart_id INT NOT NULL, arrivee_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2B5BA98CAE02FE4B (depart_id), INDEX IDX_2B5BA98CEAF07E42 (arrivee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_event (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, section_id INT NOT NULL, depart_id INT NOT NULL, arrivee_id INT NOT NULL, INDEX IDX_8DC7EEDDFD02F13 (evenement_id), INDEX IDX_8DC7EEDDD823E37A (section_id), UNIQUE INDEX UNIQ_8DC7EEDDAE02FE4B (depart_id), UNIQUE INDEX UNIQ_8DC7EEDDEAF07E42 (arrivee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INT NOT NULL, section VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_audit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, active TINYINT(1) NOT NULL, prenom VARCHAR(25) NOT NULL, email VARCHAR(50) NOT NULL, username VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, filename VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', update_at DATETIME NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_navette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_855E532E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_ptb (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C8234B5E44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_taxe (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_466329F544973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_vignette (id INT AUTO_INCREMENT NOT NULL, billet_id INT NOT NULL, nbre_de_billet INT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AB1EBEFA44973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vignette (id INT AUTO_INCREMENT NOT NULL, guichet_id INT NOT NULL, type_id INT NOT NULL, numero_dernier_billet INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B4B561ED75742EE (guichet_id), INDEX IDX_B4B561EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79C54C8C93 FOREIGN KEY (type_id) REFERENCES type_audit (id)');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet_event (id)');
        $this->addSql('ALTER TABLE billet_event ADD CONSTRAINT FK_65D11774D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4DD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE billet_navette ADD CONSTRAINT FK_13476BB4D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65BE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE billet_ptb ADD CONSTRAINT FK_76110B65FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE commande_navette ADD CONSTRAINT FK_2CEFBD6E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE commande_ptb ADD CONSTRAINT FK_440F1A9444973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE commande_taxe ADD CONSTRAINT FK_3D5E2E0A44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE commande_vignette ADD CONSTRAINT FK_DD6B4E8444973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE guichet ADD CONSTRAINT FK_3C05CCE96AB213CC FOREIGN KEY (lieu_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE navette ADD CONSTRAINT FK_DA54CFCED12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE navette ADD CONSTRAINT FK_DA54CFCE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE ptb ADD CONSTRAINT FK_435F0DC4D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE ptb ADD CONSTRAINT FK_435F0DC4D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE stock_navette ADD CONSTRAINT FK_C3F2DF6D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE stock_ptb ADD CONSTRAINT FK_3531B85244973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE stock_taxe ADD CONSTRAINT FK_4F28772D44973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE stock_vignette ADD CONSTRAINT FK_448D025C44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ABE9DC9C7 FOREIGN KEY (ptb_id) REFERENCES ptb (id)');
        $this->addSql('ALTER TABLE tracabilite ADD CONSTRAINT FK_7E1E9A8ADD1420CC FOREIGN KEY (navette_id) REFERENCES navette (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDD823E37A FOREIGN KEY (section_id) REFERENCES section_event (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDAE02FE4B FOREIGN KEY (depart_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE trajet_event ADD CONSTRAINT FK_8DC7EEDDEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE vente_navette ADD CONSTRAINT FK_855E532E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_navette (id)');
        $this->addSql('ALTER TABLE vente_ptb ADD CONSTRAINT FK_C8234B5E44973C78 FOREIGN KEY (billet_id) REFERENCES billet_ptb (id)');
        $this->addSql('ALTER TABLE vente_taxe ADD CONSTRAINT FK_466329F544973C78 FOREIGN KEY (billet_id) REFERENCES billet_taxe (id)');
        $this->addSql('ALTER TABLE vente_vignette ADD CONSTRAINT FK_AB1EBEFA44973C78 FOREIGN KEY (billet_id) REFERENCES vignette (id)');
        $this->addSql('ALTER TABLE vignette ADD CONSTRAINT FK_B4B561ED75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE vignette ADD CONSTRAINT FK_B4B561EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF1D74413');
        $this->addSql('ALTER TABLE commande_navette DROP FOREIGN KEY FK_2CEFBD6E44973C78');
        $this->addSql('ALTER TABLE stock_navette DROP FOREIGN KEY FK_C3F2DF6D44973C78');
        $this->addSql('ALTER TABLE vente_navette DROP FOREIGN KEY FK_855E532E44973C78');
        $this->addSql('ALTER TABLE commande_ptb DROP FOREIGN KEY FK_440F1A9444973C78');
        $this->addSql('ALTER TABLE stock_ptb DROP FOREIGN KEY FK_3531B85244973C78');
        $this->addSql('ALTER TABLE vente_ptb DROP FOREIGN KEY FK_C8234B5E44973C78');
        $this->addSql('ALTER TABLE commande_taxe DROP FOREIGN KEY FK_3D5E2E0A44973C78');
        $this->addSql('ALTER TABLE stock_taxe DROP FOREIGN KEY FK_4F28772D44973C78');
        $this->addSql('ALTER TABLE vente_taxe DROP FOREIGN KEY FK_466329F544973C78');
        $this->addSql('ALTER TABLE navette DROP FOREIGN KEY FK_DA54CFCE8F5EA509');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65FD02F13');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDFD02F13');
        $this->addSql('ALTER TABLE billet_event DROP FOREIGN KEY FK_65D11774D75742EE');
        $this->addSql('ALTER TABLE billet_navette DROP FOREIGN KEY FK_13476BB4D75742EE');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65D75742EE');
        $this->addSql('ALTER TABLE vignette DROP FOREIGN KEY FK_B4B561ED75742EE');
        $this->addSql('ALTER TABLE guichet DROP FOREIGN KEY FK_3C05CCE96AB213CC');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CAE02FE4B');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CEAF07E42');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDAE02FE4B');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDEAF07E42');
        $this->addSql('ALTER TABLE billet_navette DROP FOREIGN KEY FK_13476BB4DD1420CC');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8ADD1420CC');
        $this->addSql('ALTER TABLE billet_ptb DROP FOREIGN KEY FK_76110B65BE9DC9C7');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8ABE9DC9C7');
        $this->addSql('ALTER TABLE ptb DROP FOREIGN KEY FK_435F0DC4D823E37A');
        $this->addSql('ALTER TABLE trajet_event DROP FOREIGN KEY FK_8DC7EEDDD823E37A');
        $this->addSql('ALTER TABLE navette DROP FOREIGN KEY FK_DA54CFCED12A823');
        $this->addSql('ALTER TABLE ptb DROP FOREIGN KEY FK_435F0DC4D12A823');
        $this->addSql('ALTER TABLE billet_event DROP FOREIGN KEY FK_65D11774D12A823');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBC54C8C93');
        $this->addSql('ALTER TABLE vignette DROP FOREIGN KEY FK_B4B561EC54C8C93');
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79C54C8C93');
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79A76ED395');
        $this->addSql('ALTER TABLE tracabilite DROP FOREIGN KEY FK_7E1E9A8AA76ED395');
        $this->addSql('ALTER TABLE commande_vignette DROP FOREIGN KEY FK_DD6B4E8444973C78');
        $this->addSql('ALTER TABLE stock_vignette DROP FOREIGN KEY FK_448D025C44973C78');
        $this->addSql('ALTER TABLE vente_vignette DROP FOREIGN KEY FK_AB1EBEFA44973C78');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE audit');
        $this->addSql('DROP TABLE billet_event');
        $this->addSql('DROP TABLE billet_navette');
        $this->addSql('DROP TABLE billet_ptb');
        $this->addSql('DROP TABLE billet_taxe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE commande_navette');
        $this->addSql('DROP TABLE commande_ptb');
        $this->addSql('DROP TABLE commande_taxe');
        $this->addSql('DROP TABLE commande_vignette');
        $this->addSql('DROP TABLE destinateur');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE guichet');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE navette');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE ptb');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE section_event');
        $this->addSql('DROP TABLE stock_navette');
        $this->addSql('DROP TABLE stock_ptb');
        $this->addSql('DROP TABLE stock_taxe');
        $this->addSql('DROP TABLE stock_vignette');
        $this->addSql('DROP TABLE tracabilite');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE trajet_event');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_audit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE vente_navette');
        $this->addSql('DROP TABLE vente_ptb');
        $this->addSql('DROP TABLE vente_taxe');
        $this->addSql('DROP TABLE vente_vignette');
        $this->addSql('DROP TABLE vignette');
    }
}
