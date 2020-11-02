<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102124131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE students_clubs (student_id VARCHAR(255) NOT NULL, club_id VARCHAR(255) NOT NULL, INDEX IDX_A9AE56D7CB944F1A (student_id), INDEX IDX_A9AE56D761190A32 (club_id), PRIMARY KEY(student_id, club_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE students_clubs ADD CONSTRAINT FK_A9AE56D7CB944F1A FOREIGN KEY (student_id) REFERENCES student (nsc)');
        $this->addSql('ALTER TABLE students_clubs ADD CONSTRAINT FK_A9AE56D761190A32 FOREIGN KEY (club_id) REFERENCES club (ref)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE students_clubs');
    }
}
