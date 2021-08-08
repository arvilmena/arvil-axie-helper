<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808150803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie ADD avg_attack_per_card DOUBLE PRECISION DEFAULT NULL, ADD avg_defence_per_card DOUBLE PRECISION DEFAULT NULL, ADD attack_per_usd DOUBLE PRECISION DEFAULT NULL, ADD defence_per_usd DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE marketplace_watchlist ADD should_crawl_more_page TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie DROP avg_attack_per_card, DROP avg_defence_per_card, DROP attack_per_usd, DROP defence_per_usd');
        $this->addSql('ALTER TABLE marketplace_watchlist DROP should_crawl_more_page');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
