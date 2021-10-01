<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211001191148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recently_sold_axie ADD back_card_id VARCHAR(255) DEFAULT NULL, ADD mouth_card_id VARCHAR(255) DEFAULT NULL, ADD horn_card_id VARCHAR(255) DEFAULT NULL, ADD tail_card_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recently_sold_axie ADD CONSTRAINT FK_65B587EF91A6793E FOREIGN KEY (back_card_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE recently_sold_axie ADD CONSTRAINT FK_65B587EFD0A75300 FOREIGN KEY (mouth_card_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE recently_sold_axie ADD CONSTRAINT FK_65B587EFAB1C15C0 FOREIGN KEY (horn_card_id) REFERENCES axie_card_ability (id)');
        $this->addSql('ALTER TABLE recently_sold_axie ADD CONSTRAINT FK_65B587EF1C0CC22 FOREIGN KEY (tail_card_id) REFERENCES axie_card_ability (id)');
        $this->addSql('CREATE INDEX IDX_65B587EF91A6793E ON recently_sold_axie (back_card_id)');
        $this->addSql('CREATE INDEX IDX_65B587EFD0A75300 ON recently_sold_axie (mouth_card_id)');
        $this->addSql('CREATE INDEX IDX_65B587EFAB1C15C0 ON recently_sold_axie (horn_card_id)');
        $this->addSql('CREATE INDEX IDX_65B587EF1C0CC22 ON recently_sold_axie (tail_card_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recently_sold_axie DROP FOREIGN KEY FK_65B587EF91A6793E');
        $this->addSql('ALTER TABLE recently_sold_axie DROP FOREIGN KEY FK_65B587EFD0A75300');
        $this->addSql('ALTER TABLE recently_sold_axie DROP FOREIGN KEY FK_65B587EFAB1C15C0');
        $this->addSql('ALTER TABLE recently_sold_axie DROP FOREIGN KEY FK_65B587EF1C0CC22');
        $this->addSql('DROP INDEX IDX_65B587EF91A6793E ON recently_sold_axie');
        $this->addSql('DROP INDEX IDX_65B587EFD0A75300 ON recently_sold_axie');
        $this->addSql('DROP INDEX IDX_65B587EFAB1C15C0 ON recently_sold_axie');
        $this->addSql('DROP INDEX IDX_65B587EF1C0CC22 ON recently_sold_axie');
        $this->addSql('ALTER TABLE recently_sold_axie DROP back_card_id, DROP mouth_card_id, DROP horn_card_id, DROP tail_card_id');
    }
}
