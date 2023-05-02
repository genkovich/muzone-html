<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429202423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new fields to leads table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE leads
            ADD COLUMN lessons_count INTEGER,
            ADD COLUMN direction VARCHAR(100),
            ADD COLUMN group_type VARCHAR(100),
            ADD COLUMN age VARCHAR(50)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE leads
            DROP COLUMN lessons_count,
            DROP COLUMN direction,
            DROP COLUMN group_type,
            DROP COLUMN age
        ');
    }
}
