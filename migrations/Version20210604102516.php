<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604102516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE professionnal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, entry_date DATE NOT NULL, note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_professionnal (project_id INT NOT NULL, professionnal_id INT NOT NULL, INDEX IDX_CAD5930D166D1F9C (project_id), INDEX IDX_CAD5930D7FC96A42 (professionnal_id), PRIMARY KEY(project_id, professionnal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_professionnal ADD CONSTRAINT FK_CAD5930D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_professionnal ADD CONSTRAINT FK_CAD5930D7FC96A42 FOREIGN KEY (professionnal_id) REFERENCES professionnal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_professionnal DROP FOREIGN KEY FK_CAD5930D7FC96A42');
        $this->addSql('ALTER TABLE project_professionnal DROP FOREIGN KEY FK_CAD5930D166D1F9C');
        $this->addSql('DROP TABLE professionnal');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_professionnal');
    }
}
