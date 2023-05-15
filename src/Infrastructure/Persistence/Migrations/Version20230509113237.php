<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509113237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create service_prices table and update services table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE service_prices (
            id UUID NOT NULL,
            service_id UUID NOT NULL,
            currency VARCHAR(3) NOT NULL,
            price NUMERIC(10, 2) NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE DEFAULT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        )');

        // Remove currency column from services table
        $this->addSql('ALTER TABLE services DROP currency');
        $this->addSql('ALTER TABLE services DROP price');

    }

    public function down(Schema $schema): void
    {
        // Drop service_prices table
        $this->addSql('DROP TABLE service_prices');

        // Add currency column back to services table
        $this->addSql('ALTER TABLE services ADD currency VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE services ADD price NUMERIC(10, 2) NOT NULL');
    }
}
