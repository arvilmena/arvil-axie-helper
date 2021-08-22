<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822133602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scholar (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, ronin_address LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scholar_history (id INT AUTO_INCREMENT NOT NULL, scholar_id INT NOT NULL, game_slp INT DEFAULT NULL, total_slp INT DEFAULT NULL, last_claim DATETIME DEFAULT NULL, elo INT DEFAULT NULL, rank INT DEFAULT NULL, ronin_slp INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B2162D3766B88967 (scholar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scholar_history ADD CONSTRAINT FK_B2162D3766B88967 FOREIGN KEY (scholar_id) REFERENCES scholar (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scholar_history DROP FOREIGN KEY FK_B2162D3766B88967');
        $this->addSql('DROP TABLE scholar');
        $this->addSql('DROP TABLE scholar_history');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
