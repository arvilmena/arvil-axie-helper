<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805164220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_parts DROP FOREIGN KEY FK_D24454E6560619AC');
        $this->addSql('ALTER TABLE axie_parts DROP FOREIGN KEY FK_D24454E6EA4CCB17');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6560619AC FOREIGN KEY (axie_id) REFERENCES axie (id)');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6EA4CCB17 FOREIGN KEY (axie_part_id) REFERENCES axie_part (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_parts DROP FOREIGN KEY FK_D24454E6560619AC');
        $this->addSql('ALTER TABLE axie_parts DROP FOREIGN KEY FK_D24454E6EA4CCB17');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6560619AC FOREIGN KEY (axie_id) REFERENCES axie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE axie_parts ADD CONSTRAINT FK_D24454E6EA4CCB17 FOREIGN KEY (axie_part_id) REFERENCES axie_part (id) ON DELETE CASCADE');
    }
}
