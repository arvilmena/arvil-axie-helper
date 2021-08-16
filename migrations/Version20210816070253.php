<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816070253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_result_axie DROP FOREIGN KEY FK_95F0D3128551FB9A');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D3128551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_result_axie DROP FOREIGN KEY FK_95F0D3128551FB9A');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D3128551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id)');
    }
}
