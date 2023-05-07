<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Psql\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use Domain\Lead\Lead;
use Domain\Lead\LeadFactory;
use Domain\Lead\LeadId;
use Domain\Lead\LeadRepositoryInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class LeadRepository implements LeadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private UuidFactory $uuidFactory,
        private LeadFactory $leadFactory,
    ) {
    }

    public function generateNext(): LeadId
    {
        return new LeadId((string) $this->uuidFactory->create());
    }

    public function insert(Lead $lead): void
    {
        $this->connection->executeStatement(
            'INSERT INTO leads (lead_id, contact_type, contact_value, lessons_count, direction, group_type, age, created_at, updated_at)
             VALUES (:lead_id, :contact_type, :contact_value, :lessons_count, :direction, :group_type, :age, :created_at, :updated_at)',
            [
                'lead_id' => $lead->id,
                'contact_type' => $lead->contact->type->value,
                'contact_value' => $lead->contact->value,
                'lessons_count' => $lead->lessonsCount,
                'direction' => $lead->direction?->value,
                'group_type' => $lead->groupType?->value,
                'age' => $lead->age?->value,
                'created_at' => $lead->createdAt,
                'updated_at' => $lead->updatedAt,
            ],
            [
                'lead_id' => Types::GUID,
                'contact_type' => Types::STRING,
                'contact_value' => Types::STRING,
                'lessons_count' => Types::INTEGER,
                'direction' => Types::STRING,
                'group_type' => Types::STRING,
                'age' => Types::STRING,
                'created_at' => Types::DATETIMETZ_IMMUTABLE,
                'updated_at' => Types::DATETIMETZ_IMMUTABLE,
            ],
        );
    }

    /**
     * @throws Exception
     */
    public function getList(int $limit = 10, int $offset = 0, array $filters = []): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select('lead_id, contact_type, contact_value, lessons_count, direction, group_type, age, created_at, updated_at', 'sent_at_telegram', 'sent_at_sendpulse')
            ->from('leads')
            ->orderBy('created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
        ;

        if (!empty($filters['date_from'])) {
            $qb->andWhere('created_at >= :date_from')
                ->setParameter('date_from', $filters['date_from'], Types::DATETIME_MUTABLE)
            ;
        }

        if (!empty($filters['date_to'])) {
            $qb->andWhere('created_at <= :date_to')
                ->setParameter('date_to', $filters['date_to'], Types::DATETIME_MUTABLE)
            ;
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $qb->andWhere('contact_value LIKE :search')
                ->setParameter('search', '%' . $search . '%')
            ;
        }

        $leads = $qb->executeQuery()->fetchAllAssociative();

        return \array_map(fn (array $lead) => $this->leadFactory->create($lead), $leads);
    }

    public function markTelegramSent(LeadId $leadId): void
    {
        $this->connection->executeStatement(
            'UPDATE leads SET sent_at_telegram = :sent_at WHERE lead_id = :lead_id',
            [
                'sent_at' => new \DateTimeImmutable(),
                'lead_id' => (string) $leadId,
            ],
            [
                'sent_at' => Types::DATETIMETZ_IMMUTABLE,
                'lead_id' => Types::GUID,
            ],
        );
    }

    public function markSendpulseSent(LeadId $leadId): void
    {
        $this->connection->executeStatement(
            'UPDATE leads SET sent_at_sendpulse = :sent_at WHERE lead_id = :lead_id',
            [
                'sent_at' => new \DateTimeImmutable(),
                'lead_id' => (string) $leadId,
            ],
            [
                'sent_at' => Types::DATETIMETZ_IMMUTABLE,
                'lead_id' => Types::GUID,
            ],
        );
    }
}
