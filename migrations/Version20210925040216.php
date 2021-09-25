<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925040216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recently_sold_axie (id INT AUTO_INCREMENT NOT NULL, axie_id INT NOT NULL, date DATETIME NOT NULL, price_eth DOUBLE PRECISION NOT NULL, price_usd DOUBLE PRECISION NOT NULL, INDEX IDX_65B587EF560619AC (axie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recently_sold_axie ADD CONSTRAINT FK_65B587EF560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recently_sold_axie');
    }
}
