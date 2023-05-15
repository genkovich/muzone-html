<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509172133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add soft delete to services table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE services ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE services DROP deleted_at');
    }
}
