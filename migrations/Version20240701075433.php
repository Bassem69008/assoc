<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701075433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create subject table and relationship with classroom, teacher tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FBCE3E7A41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_classroom (subject_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_A2CA4B723EDC87 (subject_id), INDEX IDX_A2CA4B76278D5A8 (classroom_id), PRIMARY KEY(subject_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE subject_classroom ADD CONSTRAINT FK_A2CA4B723EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_classroom ADD CONSTRAINT FK_A2CA4B76278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309D41807E1D');
        $this->addSql('DROP INDEX IDX_497D309D41807E1D ON classroom');
        $this->addSql('ALTER TABLE classroom DROP teacher_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A41807E1D');
        $this->addSql('ALTER TABLE subject_classroom DROP FOREIGN KEY FK_A2CA4B723EDC87');
        $this->addSql('ALTER TABLE subject_classroom DROP FOREIGN KEY FK_A2CA4B76278D5A8');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subject_classroom');
        $this->addSql('ALTER TABLE classroom ADD teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309D41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_497D309D41807E1D ON classroom (teacher_id)');
    }
}
