<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210718104733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crawl_axie_result (id INT AUTO_INCREMENT NOT NULL, crawl_id INT NOT NULL, axie_id INT NOT NULL, price_eth DOUBLE PRECISION DEFAULT NULL, price_usd DOUBLE PRECISION DEFAULT NULL, INDEX IDX_74ADA641201B0D8A (crawl_id), INDEX IDX_74ADA641560619AC (axie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id)');
        $this->addSql('ALTER TABLE crawl_axie_result ADD CONSTRAINT FK_74ADA641560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE crawl_axie_result');
    }
}
