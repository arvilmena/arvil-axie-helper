<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816042314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE axie_history (id INT AUTO_INCREMENT NOT NULL, axie_id INT NOT NULL, price_eth DOUBLE PRECISION DEFAULT NULL, price_usd DOUBLE PRECISION DEFAULT NULL, breed_count INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_8115F0B0560619AC (axie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crawl_result_axie (id INT AUTO_INCREMENT NOT NULL, crawl_id INT NOT NULL, axie_history_id INT NOT NULL, crawl_ulid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', date DATETIME NOT NULL, INDEX IDX_95F0D312201B0D8A (crawl_id), INDEX IDX_95F0D312DA7E3EF7 (axie_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE axie_history ADD CONSTRAINT FK_8115F0B0560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D312201B0D8A FOREIGN KEY (crawl_id) REFERENCES marketplace_crawl (id)');
        $this->addSql('ALTER TABLE crawl_result_axie ADD CONSTRAINT FK_95F0D312DA7E3EF7 FOREIGN KEY (axie_history_id) REFERENCES axie_history (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crawl_result_axie DROP FOREIGN KEY FK_95F0D312DA7E3EF7');
        $this->addSql('DROP TABLE axie_history');
        $this->addSql('DROP TABLE crawl_result_axie');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
