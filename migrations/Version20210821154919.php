<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821154919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE axie_notification_price (id INT AUTO_INCREMENT NOT NULL, axie_id INT NOT NULL, alert_only_when_price_below DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_17A48D3F560619AC (axie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE axie_notification_price ADD CONSTRAINT FK_17A48D3F560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie ADD number_of_zero_energy_card INT DEFAULT NULL, ADD sum_of_card_energy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marketplace_watchlist ADD exclude_when_zero_energy_card_gte INT DEFAULT NULL, ADD exclude_when_sum_of_energy_lte INT DEFAULT NULL, ADD exclude_avg_atk_per_card_lte DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE axie_notification_price');
        $this->addSql('ALTER TABLE axie DROP number_of_zero_energy_card, DROP sum_of_card_energy');
        $this->addSql('ALTER TABLE marketplace_watchlist DROP exclude_when_zero_energy_card_gte, DROP exclude_when_sum_of_energy_lte, DROP exclude_avg_atk_per_card_lte');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
