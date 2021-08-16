<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816052226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_result_axie DROP FOREIGN KEY FK_95F0D312201B0D8A');
        $this->addSql('DROP INDEX IDX_95F0D312201B0D8A ON crawl_result_axie');
        $this->addSql('ALTER TABLE crawl_result_axie ADD marketplace_watchlist_id INT DEFAULT NULL, DROP crawl_id');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D3128551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id)');
        $this->addSql('CREATE INDEX IDX_95F0D3128551FB9A ON crawl_result_axie (marketplace_watchlist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_result_axie DROP FOREIGN KEY FK_95F0D3128551FB9A');
        $this->addSql('DROP INDEX IDX_95F0D3128551FB9A ON crawl_result_axie');
        $this->addSql('ALTER TABLE crawl_result_axie ADD crawl_id INT NOT NULL, DROP marketplace_watchlist_id');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D312201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id)');
        $this->addSql('CREATE INDEX IDX_95F0D312201B0D8A ON crawl_result_axie (crawl_id)');
    }
}
