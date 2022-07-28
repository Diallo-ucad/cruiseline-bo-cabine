<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622095016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cabin_category CHANGE langue langue VARCHAR(4) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bateau_id bateau_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cabin_category_texte cabin_category_texte VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_code CHANGE code code VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabin_type_element CHANGE element element VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_price CHANGE fare_type_code fare_type_code VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fare_type_desc fare_type_desc VARCHAR(200) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lang lang VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
