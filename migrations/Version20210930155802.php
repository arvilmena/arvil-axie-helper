<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930155802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_history CHANGE price_eth price_eth NUMERIC(10, 4) NOT NULL, CHANGE price_usd price_usd NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE recently_sold_axie ADD breed_count INT DEFAULT NULL, CHANGE price_eth price_eth NUMERIC(10, 4) NOT NULL, CHANGE price_usd price_usd NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_history CHANGE price_eth price_eth DOUBLE PRECISION DEFAULT NULL, CHANGE price_usd price_usd DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE recently_sold_axie DROP breed_count, CHANGE price_eth price_eth DOUBLE PRECISION NOT NULL, CHANGE price_usd price_usd DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
