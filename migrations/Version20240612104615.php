<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612104615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Parent table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parent_entity (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, gender VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_413B87AEC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parent_entity ADD CONSTRAINT FK_413B87AEC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parent_entity DROP FOREIGN KEY FK_413B87AEC35E566A');
        $this->addSql('DROP TABLE parent_entity');
    }
}
