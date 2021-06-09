<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609125717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_metier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_metier_professionnal (service_metier_id INT NOT NULL, professionnal_id INT NOT NULL, INDEX IDX_8E6301FCB587C06A (service_metier_id), INDEX IDX_8E6301FC7FC96A42 (professionnal_id), PRIMARY KEY(service_metier_id, professionnal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_metier_professionnal ADD CONSTRAINT FK_8E6301FCB587C06A FOREIGN KEY (service_metier_id) REFERENCES service_metier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_metier_professionnal ADD CONSTRAINT FK_8E6301FC7FC96A42 FOREIGN KEY (professionnal_id) REFERENCES professionnal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_metier_professionnal DROP FOREIGN KEY FK_8E6301FCB587C06A');
        $this->addSql('DROP TABLE service_metier');
        $this->addSql('DROP TABLE service_metier_professionnal');
    }
}
