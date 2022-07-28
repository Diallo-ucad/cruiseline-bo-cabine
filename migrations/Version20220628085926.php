<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628085926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prix_forfait_config (id INT AUTO_INCREMENT NOT NULL, forfait_config_id INT NOT NULL, forfait_id INT NOT NULL, tarif_semaine INT DEFAULT NULL, tarif_jour INT DEFAULT NULL, is_actif TINYINT(1) NOT NULL, INDEX IDX_71EB1706D2F8EF7F (forfait_config_id), INDEX IDX_71EB1706906D5F2C (forfait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prix_forfait_config ADD CONSTRAINT FK_71EB1706D2F8EF7F FOREIGN KEY (forfait_config_id) REFERENCES forfait_config (id)');
        $this->addSql('ALTER TABLE prix_forfait_config ADD CONSTRAINT FK_71EB1706906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('ALTER TABLE forfait_config DROP tarif_jour, DROP tarif_semaine');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prix_forfait_config');
        $this->addSql('ALTER TABLE cabin_category CHANGE langue langue VARCHAR(4) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bateau_id bateau_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cabin_category_texte cabin_category_texte VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_code CHANGE code code VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_element CHANGE element element VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE forfait CHANGE forfait_titre forfait_titre VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type_prestation_id type_prestation_id VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE forfait_config ADD tarif_jour INT DEFAULT NULL, ADD tarif_semaine INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forfait_content CHANGE content_titre content_titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE langue langue VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_forfait CHANGE titre titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_price CHANGE fare_type_code fare_type_code VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fare_type_desc fare_type_desc VARCHAR(200) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lang lang VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
