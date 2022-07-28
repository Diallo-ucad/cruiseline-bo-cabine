<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220310153610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cabin_category (id INT AUTO_INCREMENT NOT NULL, version VARCHAR(5) NOT NULL, compagnie_id SMALLINT NOT NULL, cabin_category_code VARCHAR(5) NOT NULL, cabin_category_int SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cabin_type (id INT AUTO_INCREMENT NOT NULL, cabin_category_id INT NOT NULL, bateau_id SMALLINT DEFAULT NULL, lang VARCHAR(4) NOT NULL, name VARCHAR(60) NOT NULL, INDEX IDX_3B85521775B15AA7 (cabin_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cabin_type_code (id INT AUTO_INCREMENT NOT NULL, cabin_type_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL, INDEX IDX_42B8FA6B6A773887 (cabin_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cabin_type_element (id INT AUTO_INCREMENT NOT NULL, cabin_type_id INT DEFAULT NULL, element VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, INDEX IDX_6FB073146A773887 (cabin_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cabin_type ADD CONSTRAINT FK_3B85521775B15AA7 FOREIGN KEY (cabin_category_id) REFERENCES cabin_category (id)');
        $this->addSql('ALTER TABLE cabin_type_code ADD CONSTRAINT FK_42B8FA6B6A773887 FOREIGN KEY (cabin_type_id) REFERENCES cabin_type (id)');
        $this->addSql('ALTER TABLE cabin_type_element ADD CONSTRAINT FK_6FB073146A773887 FOREIGN KEY (cabin_type_id) REFERENCES cabin_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cabin_type DROP FOREIGN KEY FK_3B85521775B15AA7');
        $this->addSql('ALTER TABLE cabin_type_code DROP FOREIGN KEY FK_42B8FA6B6A773887');
        $this->addSql('ALTER TABLE cabin_type_element DROP FOREIGN KEY FK_6FB073146A773887');
        $this->addSql('DROP TABLE cabin_category');
        $this->addSql('DROP TABLE cabin_type');
        $this->addSql('DROP TABLE cabin_type_code');
        $this->addSql('DROP TABLE cabin_type_element');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
