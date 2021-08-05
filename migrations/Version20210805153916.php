<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805153916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE axie_gene_passing_rate_axie_part');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE axie_gene_passing_rate_axie_part (axie_gene_passing_rate_id INT NOT NULL, axie_part_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CDB829E4C2FC8F6D (axie_gene_passing_rate_id), INDEX IDX_CDB829E4EA4CCB17 (axie_part_id), PRIMARY KEY(axie_gene_passing_rate_id, axie_part_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE axie_gene_passing_rate_axie_part ADD CONSTRAINT FK_CDB829E4C2FC8F6D FOREIGN KEY (axie_gene_passing_rate_id) REFERENCES axie_gene_passing_rate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE axie_gene_passing_rate_axie_part ADD CONSTRAINT FK_CDB829E4EA4CCB17 FOREIGN KEY (axie_part_id) REFERENCES axie_part (id) ON DELETE CASCADE');
    }
}
