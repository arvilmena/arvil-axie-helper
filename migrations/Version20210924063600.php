<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924063600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE crawl_axie_result');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crawl_axie_result (id INT AUTO_INCREMENT NOT NULL, crawl_id INT DEFAULT NULL, axie_id INT DEFAULT NULL, price_eth DOUBLE PRECISION DEFAULT NULL, price_usd DOUBLE PRECISION DEFAULT NULL, breed_count SMALLINT DEFAULT NULL, crawl_date DATETIME DEFAULT NULL, INDEX IDX_74ADA641560619AC (axie_id), INDEX IDX_74ADA641201B0D8A (crawl_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
