<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806062357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie ADD attack_per_usd DOUBLE PRECISION DEFAULT NULL, ADD defence_per_usd DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE crawl_axie_result DROP attack_per_usd, DROP defence_per_usd');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie DROP attack_per_usd, DROP defence_per_usd');
        $this->addSql('ALTER TABLE crawl_axie_result ADD attack_per_usd DOUBLE PRECISION DEFAULT NULL, ADD defence_per_usd DOUBLE PRECISION DEFAULT NULL');
    }
}
