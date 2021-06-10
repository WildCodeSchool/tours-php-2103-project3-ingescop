<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610143151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_metier_professionnal DROP FOREIGN KEY FK_8E6301FCB587C06A');
        $this->addSql('DROP TABLE service_metier');
        $this->addSql('DROP TABLE service_metier_professionnal');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_metier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_metier_professionnal (service_metier_id INT NOT NULL, professionnal_id INT NOT NULL, INDEX IDX_8E6301FC7FC96A42 (professionnal_id), INDEX IDX_8E6301FCB587C06A (service_metier_id), PRIMARY KEY(service_metier_id, professionnal_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_metier_professionnal ADD CONSTRAINT FK_8E6301FC7FC96A42 FOREIGN KEY (professionnal_id) REFERENCES professionnal (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_metier_professionnal ADD CONSTRAINT FK_8E6301FCB587C06A FOREIGN KEY (service_metier_id) REFERENCES service_metier (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
