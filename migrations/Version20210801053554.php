<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801053554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl DROP INDEX UNIQ_102A4E852FF2C065, ADD INDEX IDX_102A4E852FF2C065 (second_lowest_price_axie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_crawl DROP INDEX IDX_102A4E852FF2C065, ADD UNIQUE INDEX UNIQ_102A4E852FF2C065 (second_lowest_price_axie_id)');
    }
}
