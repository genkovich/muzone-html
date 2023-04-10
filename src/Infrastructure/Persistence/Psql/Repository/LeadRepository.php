<?php
declare(strict_types=1);


namespace Infrastructure\Persistence\Psql\Repository;

use Doctrine\DBAL\Types\Types;
use Domain\Lead\Lead;
use Domain\Lead\LeadId;
use Domain\Lead\LeadRepositoryInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class LeadRepository implements LeadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private UuidFactory $uuidFactory,
    )
    {
    }

    public function generateNext(): LeadId
    {
       return new LeadId((string)$this->uuidFactory->create());
    }

    public function insert(Lead $lead): void
    {
        $this->connection->executeStatement(
            'INSERT INTO leads (lead_id, contact_type, contact_value, created_at, updated_at)
             VALUES (:lead_id, :contact_type, :contact_value, :created_at, :updated_at)',
            [
                'lead_id' => $lead->id,
                'contact_type' => $lead->contact->type->value,
                'contact_value' => $lead->contact->value,
                'created_at' => $lead->createdAt,
                'updated_at' => $lead->updatedAt,
            ],
            [
                'lead_id' => Types::GUID,
                'contact_type' => Types::STRING,
                'contact_value' => Types::STRING,
                'created_at' => Types::DATETIMETZ_IMMUTABLE,
                'updated_at' => Types::DATETIMETZ_IMMUTABLE,
            ],
        );

    }


}