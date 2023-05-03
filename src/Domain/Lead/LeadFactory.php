<?php
declare(strict_types=1);


namespace Domain\Lead;

use DateTimeImmutable;
use Domain\Age;
use Domain\Direction;
use Domain\GroupType;
use Domain\Lead\Contact\ContactFactory;
use Exception;

final readonly class LeadFactory
{
    public function __construct(
        private ContactFactory $contactFactory,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Lead
    {
        $direction = null === $data['direction'] ? null : Direction::tryFrom($data['direction']);
        $groupType = null === $data['group_type'] ? null : GroupType::tryFrom($data['group_type']);
        $age = null === $data['age'] ? null : Age::tryFrom($data['age']);

        $sentAtTelegram = null;
        if (array_key_exists('sent_at_telegram', $data)) {
            $sentAtTelegram = null === $data['sent_at_telegram'] ? null : new DateTimeImmutable($data['sent_at_telegram']);
        }

        $sentAtSendpulse = null;
        if (array_key_exists('sent_at_sendpulse', $data)) {
            $sentAtSendpulse = null === $data['sent_at_sendpulse'] ? null : new DateTimeImmutable($data['sent_at_sendpulse']);
        }


        return new Lead(
            new LeadId($data['lead_id']),
            $this->contactFactory->create($data['contact_type'], $data['contact_value']),
            $data['lessons_count'] ?? 0,
            $direction,
            $groupType,
            $age,
            new DateTimeImmutable($data['created_at']),
            new DateTimeImmutable($data['updated_at']),
            $sentAtTelegram,
            $sentAtSendpulse,
        );
    }
}