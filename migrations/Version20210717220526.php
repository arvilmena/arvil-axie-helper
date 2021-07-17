<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210717220526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl ADD lowest_price_eth NUMERIC(10, 0) DEFAULT NULL, ADD highest_price_eth NUMERIC(10, 0) DEFAULT NULL, ADD average_price_eth NUMERIC(10, 0) DEFAULT NULL, ADD lowest_price_usd NUMERIC(10, 0) DEFAULT NULL, ADD highest_price_usd NUMERIC(10, 0) DEFAULT NULL, ADD average_price_usd NUMERIC(10, 0) DEFAULT NULL, DROP lowest_price, DROP highest_price, DROP average_price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl ADD lowest_price NUMERIC(10, 0) DEFAULT NULL, ADD highest_price NUMERIC(10, 0) DEFAULT NULL, ADD average_price NUMERIC(10, 0) DEFAULT NULL, DROP lowest_price_eth, DROP highest_price_eth, DROP average_price_eth, DROP lowest_price_usd, DROP highest_price_usd, DROP average_price_usd');
    }
}
