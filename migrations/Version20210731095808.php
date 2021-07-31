<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731095808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641201B0D8A');
        $this->addSql('ALTER TABLE crawl_axie_result CHANGE crawl_id crawl_id INT DEFAULT NULL, CHANGE axie_id axie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641201B0D8A');
        $this->addSql('ALTER TABLE crawl_axie_result CHANGE crawl_id crawl_id INT NOT NULL, CHANGE axie_id axie_id INT NOT NULL');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
