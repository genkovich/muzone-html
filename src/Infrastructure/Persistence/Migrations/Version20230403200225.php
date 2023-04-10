<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403200225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make leads table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE leads
            (
                lead_id UUID,
                contact_type VARCHAR(80) NOT NULL,
                contact_value VARCHAR(80) NOT NULL ,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(lead_id)
            )
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE leads');
    }
}
