<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210717214345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl ADD marketplace_watchlist_id INT DEFAULT NULL, CHANGE url url LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE marketplace_crawl ADD CONSTRAINT FK_102A4E858551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id)');
        $this->addSql('CREATE INDEX IDX_102A4E858551FB9A ON marketplace_crawl (marketplace_watchlist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl DROP FOREIGN KEY FK_102A4E858551FB9A');
        $this->addSql('DROP INDEX IDX_102A4E858551FB9A ON marketplace_crawl');
        $this->addSql('ALTER TABLE marketplace_crawl DROP marketplace_watchlist_id, CHANGE url url LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
