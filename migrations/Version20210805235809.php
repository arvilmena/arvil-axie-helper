<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805235809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE axie_parts (axie_id INT NOT NULL, axie_part_id VARCHAR(255) NOT NULL, INDEX IDX_D24454E6560619AC (axie_id), INDEX IDX_D24454E6EA4CCB17 (axie_part_id), PRIMARY KEY(axie_id, axie_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE axie_card_ability (id VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, attack INT DEFAULT NULL, defence INT DEFAULT NULL, energy INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, background_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE axie_gene_passing_rate (id INT AUTO_INCREMENT NOT NULL, axie_id INT NOT NULL, part_id VARCHAR(255) NOT NULL, axie_card_ability_id VARCHAR(255) DEFAULT NULL, passing_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_ADD1B2D8560619AC (axie_id), INDEX IDX_ADD1B2D84CE34BEC (part_id), INDEX IDX_ADD1B2D8D15E6E5F (axie_card_ability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE axie_genes (id INT AUTO_INCREMENT NOT NULL, axie_id INT NOT NULL, part_id VARCHAR(255) NOT NULL, card_ability_id VARCHAR(255) DEFAULT NULL, gene_type VARCHAR(3) NOT NULL, INDEX IDX_C903F127560619AC (axie_id), INDEX IDX_C903F1274CE34BEC (part_id), INDEX IDX_C903F127EC6445BC (card_ability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE axie_part (id VARCHAR(255) NOT NULL, card_ability_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_46BB6B73EC6445BC (card_ability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE axie_raw_data (axie_id INT NOT NULL, raw_data LONGTEXT DEFAULT NULL, raw_data_brief LONGTEXT DEFAULT NULL, PRIMARY KEY(axie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6EA4CCB17 FOREIGN KEY (axie_part_id) REFERENCES axie_part (id)');
        $this->addSql('ALTER TABLE axie_gene_passing_rate ADD CONSTRAINT FK_ADD1B2D8560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie_gene_passing_rate ADD CONSTRAINT FK_ADD1B2D84CE34BEC FOREIGN KEY (part_id) REFERENCES axie_part (id)');
        $this->addSql('ALTER TABLE axie_gene_passing_rate ADD CONSTRAINT FK_ADD1B2D8D15E6E5F FOREIGN KEY (axie_card_ability_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE axie_genes ADD CONSTRAINT FK_C903F127560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie_genes ADD CONSTRAINT FK_C903F1274CE34BEC FOREIGN KEY (part_id) REFERENCES axie_part (id)');
        $this->addSql('ALTER TABLE axie_genes ADD CONSTRAINT FK_C903F127EC6445BC FOREIGN KEY (card_ability_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE axie_part ADD CONSTRAINT FK_46BB6B73EC6445BC FOREIGN KEY (card_ability_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE axie_raw_data ADD CONSTRAINT FK_AC8CC3DD560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie ADD dominant_class_purity DOUBLE PRECISION DEFAULT NULL, ADD r1_class_purity DOUBLE PRECISION DEFAULT NULL, ADD r2_class_purity DOUBLE PRECISION DEFAULT NULL, ADD pureness INT DEFAULT NULL, ADD is_processed TINYINT(1) DEFAULT \'0\' NOT NULL, ADD class VARCHAR(255) DEFAULT NULL, ADD hp INT DEFAULT NULL, ADD speed INT DEFAULT NULL, ADD skill INT DEFAULT NULL, ADD morale INT DEFAULT NULL, ADD quality DOUBLE PRECISION DEFAULT NULL, CHANGE raw_data encoded_genes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE marketplace_watchlist ADD order_weight INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_gene_passing_rate DROP FOREIGN KEY FK_ADD1B2D8D15E6E5F');
        $this->addSql('ALTER TABLE axie_genes DROP FOREIGN KEY FK_C903F127EC6445BC');
        $this->addSql('ALTER TABLE axie_part DROP FOREIGN KEY FK_46BB6B73EC6445BC');
        $this->addSql('ALTER TABLE axie_parts DROP FOREIGN KEY FK_D24454E6EA4CCB17');
        $this->addSql('ALTER TABLE axie_gene_passing_rate DROP FOREIGN KEY FK_ADD1B2D84CE34BEC');
        $this->addSql('ALTER TABLE axie_genes DROP FOREIGN KEY FK_C903F1274CE34BEC');
        $this->addSql('DROP TABLE axie_parts');
        $this->addSql('DROP TABLE axie_card_ability');
        $this->addSql('DROP TABLE axie_gene_passing_rate');
        $this->addSql('DROP TABLE axie_genes');
        $this->addSql('DROP TABLE axie_part');
        $this->addSql('DROP TABLE axie_raw_data');
        $this->addSql('ALTER TABLE axie DROP dominant_class_purity, DROP r1_class_purity, DROP r2_class_purity, DROP pureness, DROP is_processed, DROP class, DROP hp, DROP speed, DROP skill, DROP morale, DROP quality, CHANGE encoded_genes raw_data LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE marketplace_watchlist DROP order_weight');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
