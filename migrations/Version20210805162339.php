<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805162339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_gene_passing_rate ADD part_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE axie_gene_passing_rate ADD CONSTRAINT FK_ADD1B2D84CE34BEC FOREIGN KEY (part_id) REFERENCES axie_part (id)');
        $this->addSql('CREATE INDEX IDX_ADD1B2D84CE34BEC ON axie_gene_passing_rate (part_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_gene_passing_rate DROP FOREIGN KEY FK_ADD1B2D84CE34BEC');
        $this->addSql('DROP INDEX IDX_ADD1B2D84CE34BEC ON axie_gene_passing_rate');
        $this->addSql('ALTER TABLE axie_gene_passing_rate DROP part_id');
    }
}
