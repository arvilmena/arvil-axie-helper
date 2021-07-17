<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210717223706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE marketplace_crawl CHANGE lowest_price_eth lowest_price_eth DOUBLE PRECISION DEFAULT NULL, CHANGE highest_price_eth highest_price_eth DOUBLE PRECISION DEFAULT NULL, CHANGE average_price_eth average_price_eth DOUBLE PRECISION DEFAULT NULL, CHANGE lowest_price_usd lowest_price_usd DOUBLE PRECISION DEFAULT NULL, CHANGE highest_price_usd highest_price_usd DOUBLE PRECISION DEFAULT NULL, CHANGE average_price_usd average_price_usd DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE marketplace_crawl CHANGE lowest_price_eth lowest_price_eth NUMERIC(10, 0) DEFAULT NULL, CHANGE highest_price_eth highest_price_eth NUMERIC(10, 0) DEFAULT NULL, CHANGE average_price_eth average_price_eth NUMERIC(10, 0) DEFAULT NULL, CHANGE lowest_price_usd lowest_price_usd NUMERIC(10, 0) DEFAULT NULL, CHANGE highest_price_usd highest_price_usd NUMERIC(10, 0) DEFAULT NULL, CHANGE average_price_usd average_price_usd NUMERIC(10, 0) DEFAULT NULL');
    }
}
