<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303184030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestataire_promotion (prestataire_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_8D5A971BE3DB2B7 (prestataire_id), INDEX IDX_8D5A971139DF194 (promotion_id), PRIMARY KEY(prestataire_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestataire_stage (prestataire_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_95F3A00EBE3DB2B7 (prestataire_id), INDEX IDX_95F3A00E2298D193 (stage_id), PRIMARY KEY(prestataire_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prestataire_promotion ADD CONSTRAINT FK_8D5A971BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestataire_promotion ADD CONSTRAINT FK_8D5A971139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestataire_stage ADD CONSTRAINT FK_95F3A00EBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestataire_stage ADD CONSTRAINT FK_95F3A00E2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD categorie_id INT DEFAULT NULL, ADD internaute_id INT DEFAULT NULL, ADD prestataire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ACAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ABE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6ABCF5E72D ON images (categorie_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6ACAF41882 ON images (internaute_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6ABE3DB2B7 ON images (prestataire_id)');
        $this->addSql('ALTER TABLE promotion ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1BCF5E72D ON promotion (categorie_id)');
        $this->addSql('ALTER TABLE utilisateur ADD internaute_id INT DEFAULT NULL, ADD prestataire_id INT DEFAULT NULL, ADD commune_id INT DEFAULT NULL, ADD localite_id INT DEFAULT NULL, ADD code_postal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3924DD2B5 FOREIGN KEY (localite_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3B2B59251 FOREIGN KEY (code_postal_id) REFERENCES code_postal (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3CAF41882 ON utilisateur (internaute_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3BE3DB2B7 ON utilisateur (prestataire_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3131A4F72 ON utilisateur (commune_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3924DD2B5 ON utilisateur (localite_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3B2B59251 ON utilisateur (code_postal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire_promotion DROP FOREIGN KEY FK_8D5A971BE3DB2B7');
        $this->addSql('ALTER TABLE prestataire_promotion DROP FOREIGN KEY FK_8D5A971139DF194');
        $this->addSql('ALTER TABLE prestataire_stage DROP FOREIGN KEY FK_95F3A00EBE3DB2B7');
        $this->addSql('ALTER TABLE prestataire_stage DROP FOREIGN KEY FK_95F3A00E2298D193');
        $this->addSql('DROP TABLE prestataire_promotion');
        $this->addSql('DROP TABLE prestataire_stage');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ABCF5E72D');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ACAF41882');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ABE3DB2B7');
        $this->addSql('DROP INDEX IDX_E01FBE6ABCF5E72D ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6ACAF41882 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6ABE3DB2B7 ON images');
        $this->addSql('ALTER TABLE images DROP categorie_id, DROP internaute_id, DROP prestataire_id');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1BCF5E72D');
        $this->addSql('DROP INDEX IDX_C11D7DD1BCF5E72D ON promotion');
        $this->addSql('ALTER TABLE promotion DROP categorie_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CAF41882');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BE3DB2B7');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3131A4F72');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3924DD2B5');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3B2B59251');
        $this->addSql('DROP INDEX IDX_1D1C63B3CAF41882 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3BE3DB2B7 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3131A4F72 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3924DD2B5 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3B2B59251 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP internaute_id, DROP prestataire_id, DROP commune_id, DROP localite_id, DROP code_postal_id');
    }
}
