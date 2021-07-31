<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731062548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641201B0D8A');
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641560619AC');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641560619AC FOREIGN KEY (axie_id) REFERENCES axie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marketplace_crawl DROP FOREIGN KEY FK_102A4E858551FB9A');
        $this->addSql('ALTER TABLE marketplace_crawl ADD CONSTRAINT FK_102A4E858551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641201B0D8A');
        $this->addSql('ALTER TABLE crawl_axie_result DROP FOREIGN KEY FK_74ADA641560619AC');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id)');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE marketplace_crawl DROP FOREIGN KEY FK_102A4E858551FB9A');
        $this->addSql('ALTER TABLE marketplace_crawl ADD CONSTRAINT FK_102A4E858551FB9A FOREIGN KEY (marketplace_watchlist_id) REFERENCES marketplace_watchlist (id)');
    }
}
