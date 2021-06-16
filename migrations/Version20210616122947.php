<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616122947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD place VARCHAR(255) NOT NULL, ADD client VARCHAR(255) NOT NULL, ADD mission_ingescop VARCHAR(255) NOT NULL, ADD budget VARCHAR(255) NOT NULL, ADD calendar VARCHAR(255) NOT NULL, ADD work_in_progress VARCHAR(255) NOT NULL, ADD resume LONGTEXT NOT NULL, ADD photo_one VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP place, DROP client, DROP mission_ingescop, DROP budget, DROP calendar, DROP work_in_progress, DROP resume, DROP photo_one');
    }
}
