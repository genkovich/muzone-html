<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504193244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create services table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE services (
                service_id UUID NOT NULL,
                title VARCHAR(255) NOT NULL,
                price NUMERIC(10, 2) NOT NULL,
                currency VARCHAR(5) NOT NULL,
                direction VARCHAR(255) NOT NULL,
                lessons_count INT NOT NULL,
                age VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
                PRIMARY KEY(service_id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE services');
    }
}
