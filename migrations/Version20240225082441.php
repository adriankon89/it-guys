<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225082441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE it_guy_competence (it_guy_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_61CA82AF40BA860C (it_guy_id), INDEX IDX_61CA82AF15761DAB (competence_id), PRIMARY KEY(it_guy_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE it_guy_competence ADD CONSTRAINT FK_61CA82AF40BA860C FOREIGN KEY (it_guy_id) REFERENCES it_guy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE it_guy_competence ADD CONSTRAINT FK_61CA82AF15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE it_guy_competence DROP FOREIGN KEY FK_61CA82AF40BA860C');
        $this->addSql('ALTER TABLE it_guy_competence DROP FOREIGN KEY FK_61CA82AF15761DAB');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE it_guy_competence');
    }
}
