<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503131711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sent_at columns to leads table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE leads ADD sent_at_telegram TIMESTAMP WITH TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE leads ADD sent_at_sendpulse TIMESTAMP WITH TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE leads DROP sent_at_telegram');
        $this->addSql('ALTER TABLE leads DROP sent_at_sendpulse');
    }
}
