<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622092201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forfait_content DROP FOREIGN KEY FK_8ED15328906D5F2C');
        $this->addSql('ALTER TABLE forfait_config DROP FOREIGN KEY FK_AA1D2179305D3E33');
        $this->addSql('ALTER TABLE forfait DROP FOREIGN KEY FK_BBB5C4828D6E8909');
        $this->addSql('CREATE TABLE type_price (id INT AUTO_INCREMENT NOT NULL, fare_type_code VARCHAR(150) NOT NULL, fare_type_desc VARCHAR(200) DEFAULT NULL, lang VARCHAR(50) NOT NULL, company_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE forfait');
        $this->addSql('DROP TABLE forfait_category');
        $this->addSql('DROP TABLE forfait_config');
        $this->addSql('DROP TABLE forfait_content');
        $this->addSql('DROP TABLE type_forfait');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forfait (id INT AUTO_INCREMENT NOT NULL, type_forfait_id INT NOT NULL, forfait_titre VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, actif TINYINT(1) NOT NULL, type_prestation_id VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BBB5C4828D6E8909 (type_forfait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forfait_category (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, actif TINYINT(1) NOT NULL, code INT NOT NULL, compagnie_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forfait_config (id INT AUTO_INCREMENT NOT NULL, forfait_content_id INT NOT NULL, tarif_jour INT DEFAULT NULL, tarif_semaine INT DEFAULT NULL, actif TINYINT(1) NOT NULL, bateau_id INT NOT NULL, currency_id INT NOT NULL, cabin_category_id INT NOT NULL, cabin_type_id INT NOT NULL, port_id INT NOT NULL, INDEX IDX_AA1D2179305D3E33 (forfait_content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forfait_content (id INT AUTO_INCREMENT NOT NULL, forfait_id INT NOT NULL, content_titre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, langue VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adult_only TINYINT(1) NOT NULL, position INT NOT NULL, nb_personne INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8ED15328906D5F2C (forfait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_forfait (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, actif TINYINT(1) NOT NULL, code INT NOT NULL, compagnie_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE forfait ADD CONSTRAINT FK_BBB5C4828D6E8909 FOREIGN KEY (type_forfait_id) REFERENCES type_forfait (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE forfait_config ADD CONSTRAINT FK_AA1D2179305D3E33 FOREIGN KEY (forfait_content_id) REFERENCES forfait_content (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE forfait_content ADD CONSTRAINT FK_8ED15328906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE type_price');
        $this->addSql('ALTER TABLE cabin_category CHANGE langue langue VARCHAR(4) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bateau_id bateau_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cabin_category_texte cabin_category_texte VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_code CHANGE code code VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_element CHANGE element element VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
